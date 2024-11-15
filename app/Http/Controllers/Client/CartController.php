<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;


class CartController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user) {
            $cartData = $this->getCartItemsData($user->id);
        } else {
            $cartData = $this->getCartItemsData(null);
        }

        $processedItems = $cartData['processedItems'];
        $total = $cartData['totalCartAmount'];

        return view('client.pages.cart', compact('processedItems', 'total'));
    }

    public function addToCart(AddToCartRequest $request)
    {
        $user = auth()->user();

        $productVariantId = $request->input('product_variant_id');
        $quantity = $request->input('quantity', 1);
        $quantityProduct = $request->input('quantityProduct');

        if ($user) {

            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            $currentQuantity = $cartItem ? $cartItem->quantity : 0;

            if ($currentQuantity + $quantity > $quantityProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá giới hạn cho phép!']);
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

            $processedItemsData = $this->getCartItemsData($user->id);

            return response()->json([
                'message' => 'Thêm sản phẩm vào giỏ hàng thành công!',
                'cartItems' => $processedItemsData['processedItems'],
                'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
            ]);
        } else {

            $cart = session()->get('cart', ['items' => []]);


            $cartItem = collect($cart['items'])->firstWhere('product_variant_id', $productVariantId);
            $currentQuantity = $cartItem ? $cartItem['quantity'] : 0;


            $coutQuantity = $currentQuantity + $quantity;

            if ($coutQuantity > $quantityProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá giới hạn cho phép!']);
            }

            if ($cartItem) {
                $index = collect($cart['items'])->search(function ($item) use ($productVariantId) {
                    return $item['product_variant_id'] === $productVariantId;
                });

                $cart['items'][$index]['quantity'] += $quantity;
            } else {
                $cart['items'][] = [
                    'product_variant_id' => $productVariantId,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cart', $cart);

            $processedItemsData = $this->getCartItemsData(null);

            return response()->json([
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartItems' => $processedItemsData['processedItems'],
                'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
            ]);

        }
    }


    public function updateQuantity(Request $request)
    {

        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $user = auth()->user();

        if ($user) {

            $cartItem = CartItem::with('productVariant')->find($id);

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();

                $totalPrice = $cartItem->productVariant->price_sale * $cartItem->quantity;

                $totalCartPrice = CartItem::whereHas('cart', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->with('productVariant')->get()->sum(function ($item) {
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
        } else {
            $sessionCart = session()->get('cart', ['items' => []]);
            $itemFound = false;
            foreach ($sessionCart['items'] as &$item) {
                if ($item['product_variant_id'] == (string) $id) {
                    $item['quantity'] = $quantity;
                    $itemFound = true;
                    break;
                }
            }

            if (!$itemFound) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng!',
                ]);
            }

            session()->put('cart', $sessionCart);

            $productVariant = ProductVariant::find($id);
            $totalPrice = $productVariant ? $productVariant->price_sale * $quantity : 0;

            $totalCartPrice = collect($sessionCart['items'])->sum(function ($item) {
                $productVariant = ProductVariant::find($item['product_variant_id']);
                return $productVariant ? $productVariant->price_sale * $item['quantity'] : 0;
            });

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật số lượng trong giỏ hàng thành công!',
                'new_quantity' => $quantity,
                'total_price' => $totalPrice,
                'total_cart_price' => $totalCartPrice,
            ]);
        }
    }


    public function deleteToCart(Request $request)
    {
        $id = $request->input('id');

        $user = auth()->user();

        if ($user) {
            $cartItem = CartItem::where('id', $id)->whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();

            if ($cartItem) {
                $cartItem->delete();

                $processedItemsData = $this->getCartItemsData($user->id);

                return response()->json([
                    'message' => 'Item deleted successfully',
                    'cartItems' => $processedItemsData['processedItems'],
                    'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
                    'totalCartAmount' => $processedItemsData['totalCartAmount'],
                ]);
            }

            return response()->json(['message' => 'Item not found'], 404);
        } else {
            $sessionCart = session()->get('cart', ['items' => []]);

            $itemFound = false;
            foreach ($sessionCart['items'] as $key => $item) {
                if ($item['product_variant_id'] == (string) $id) {
                    unset($sessionCart['items'][$key]);
                    $itemFound = true;
                    break;
                }
            }

            session()->put('cart', $sessionCart);

            if ($itemFound) {

                $processedItemsData = $this->getCartItemsData(null);

                return response()->json([
                    'message' => 'Item deleted from session cart successfully',
                    'cartItems' => $processedItemsData['processedItems'],
                    'uniqueVariantCount' => $processedItemsData['uniqueVariantCount'],
                    'totalCartAmount' => $processedItemsData['totalCartAmount'],
                ]);
            } else {
                return response()->json(['message' => 'Item not found in session cart'], 404);
            }
        }
    }


    public function getCartItemsData($id)
    {
        if ($id) {
            $cartItems = CartItem::whereHas('cart', function ($query) use ($id) {
                $query->where('user_id', $id);
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
                    'total_price' => $totalPriceForItem,
                ];
            }

            return [
                'processedItems' => $processedItems,
                'uniqueVariantCount' => $uniqueVariantCount,
                'totalCartAmount' => $totalCartAmount,
            ];
        } else {
            $sessionCart = session()->get('cart', ['items' => []]);

            $cartItems = collect($sessionCart['items'])->map(function ($item) {
                $productVariant = ProductVariant::with('product', 'size', 'color')->find($item['product_variant_id']);
                return (object) [
                    'productVariant' => $productVariant,
                    'quantity' => $item['quantity'],
                ];
            })->filter(function ($item) {
                return $item->productVariant
                    && $item->productVariant->product->is_active
                    && $item->productVariant->product->category->is_active;
            });

            $groupedItems = $cartItems->groupBy(function ($item) {
                return $item->productVariant->id;
            });

            $processedItems = [];
            $totalCartAmount = 0;

            foreach ($groupedItems as $variantId => $items) {
                $productVariant = $items->first()->productVariant;
                $totalQuantity = $items->sum('quantity');
                $price = $productVariant->price_sale;
                $totalPriceForItem = $price * $totalQuantity;
                $totalCartAmount += $totalPriceForItem;

                $processedItems[] = (object) [
                    'id' => $variantId,
                    'productVariant' => $productVariant,
                    'quantity' => $totalQuantity,
                    'price_sale' => $price,
                    'total_price' => $totalPriceForItem,
                    'slug' => $productVariant->product->slug,
                    'img_thumb' => $productVariant->product->img_thumb,
                    'size_name' => $productVariant->size->name ?? '',
                    'color_name' => $productVariant->color->name ?? '',
                ];
            }

            $uniqueVariantCount = count($processedItems);

            return [
                'processedItems' => $processedItems,
                'uniqueVariantCount' => $uniqueVariantCount,
                'totalCartAmount' => $totalCartAmount,
            ];
        }

    }

}
