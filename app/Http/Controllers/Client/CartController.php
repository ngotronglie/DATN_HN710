<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->whereHas('productVariant.product', function ($query) {
                $query->where('is_active', 1)
                    ->whereHas('category', function ($query) {
                        $query->where('is_active', 1);
                    });
            })
            ->with('productVariant')
            ->get();

        $groupedItems = $cartItems->groupBy('product_variant_id');

        $processedItems = [];

        foreach ($groupedItems as $variantId => $items) {
            $id = $items->first()->id;

            $productVariant = $items->first()->productVariant;

            $totalQuantity = $items->sum('quantity');

            $price = $productVariant->price_sale;

            $processedItems[] = (object) [
                'id' => $id,
                'productVariant' => $productVariant,
                'quantity' => $totalQuantity,
                'total_price' => $price * $totalQuantity,
            ];
        }

        $total = collect($processedItems)->sum('total_price');

        return view('client.pages.cart', compact('processedItems', 'total', 'cartItems'));
    }


    public function addToCart(Request $request)
    {
        $user = auth()->user();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $productVariantId = $request->input('product_variant_id');
        $quantity = $request->input('quantity', 1);
        $quantityProduct = $request->input('quantityProduct');

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $productVariantId)
            ->first();

        $currentQuantity = $cartItem ? $cartItem->quantity : 0;

        if ($currentQuantity + $quantity > $quantityProduct) {
            return response()->json(['message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá giới hạn cho phép!'], 400);
        }

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariantId,
                'quantity' => $quantity,
            ]);
        }

        $processedItemsData = $this->getCartItemsData(Auth::user());

        return response()->json([
            'message' => 'Item deleted successfully',
            'cartItems' => $processedItemsData['processedItems'],
            'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
        ]);
    }


    public function updateQuantity(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $cartItem = CartItem::with('productVariant')->find($id);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();

            $totalPrice = $cartItem->productVariant->price_sale * $cartItem->quantity;

            $totalCartPrice = CartItem::whereHas('cart', function ($query) {
                $query->where('user_id', auth()->id());
            })->with('productVariant')
                ->get()
                ->sum(function ($item) {
                    return $item->productVariant->price_sale * $item->quantity;
                });


            return response()->json([
                'success' => true,
                'message' => 'Cập nhật số lượng thành công!',
                'new_quantity' => $cartItem->quantity,
                'price_sale' => $cartItem->productVariant->price_sale,
                'total_price' => $totalPrice,
                'total_cart_price' => $totalCartPrice,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng!',
        ]);
    }

    public function deleteToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $id = $request->input('id');

        $cartItem = CartItem::where('id', $id)->whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->first();

        if ($cartItem) {
            $cartItem->delete();

            $processedItemsData = $this->getCartItemsData(Auth::user());

            return response()->json([
                'message' => 'Item deleted successfully',
                'cartItems' => $processedItemsData['processedItems'],
                'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
                'totalCartAmount' => $processedItemsData['totalCartAmount'],

            ]);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function getCartItemsData($user)
    {
        $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->whereHas('productVariant.product', function ($query) {
                $query->where('is_active', 1)
                    ->whereHas('category', function ($query) {
                        $query->where('is_active', 1);
                    });
            })
            ->with('productVariant.product', 'productVariant.size', 'productVariant.color')  // Thêm eager loading cho size và color
            ->get();

        $groupedItems = $cartItems->groupBy('product_variant_id');

        $processedItems = [];
        $uniqueVariantCount = $groupedItems->count();
        $totalCartAmount = 0;

        foreach ($groupedItems as $variantId => $items) {
            $id = $items->first()->id;

            $productVariant = $items->first()->productVariant;


            $totalQuantity = $items->sum('quantity');

            $price = $productVariant->price_sale;

            $totalPriceForItem = $price * $totalQuantity;
            $totalCartAmount += $totalPriceForItem;

            $product = $productVariant->product;
            $sizeName = $productVariant->size->name ?? '';
            $colorName = $productVariant->color->name ?? '';


            $processedItems[] = (object) [
                'id' => $id,
                'productVariant' => $productVariant,
                'quantity' => $totalQuantity,
                'price_sale' => $price,
                'slug' => $product->slug,
                'img_thumb' => $product->img_thumb,
                'size_name' => $sizeName,
                'color_name' => $colorName,
            ];
        }

        return [
            'processedItems' => $processedItems,
            'uniqueVariantCount' => $uniqueVariantCount,
            'totalCartAmount' => $totalCartAmount,
        ];
    }






}
