<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\FavoriteItem;
use Illuminate\Http\Request;


class FavoriteController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user) {
            session()->forget('user_cart');

            $favoriteProductData = $this->getFavoriteProductItemsData($user->id);
            $favoriteProducts = $favoriteProductData['favoriteProducts'];

            return view('client.pages.wishlist', compact('favoriteProducts'));
        } else {
            return response()->json([
                'status' => false,
                'script' => "
                    isSwalOpen = true;
                    Swal.fire({
                        title: 'Bạn cần phải đăng nhập',
                        text: 'Vui lòng đăng nhập để vào mục yêu thích',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Đăng nhập',
                        cancelButtonText: 'Hủy',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';  // Điều hướng đến trang đăng nhập
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Nếu người dùng nhấn nút Hủy
                            console.log('Hủy bỏ đăng nhập');
                        }
                    }).finally(() => {
                        isSwalOpen = false;
                    });
                "
            ]);

        }
    }


    public function addToFavorite(Request $request)
    {
        //dd($request);
        $user = auth()->user();

        $productId = $request->input('product_id');

        if ($user) {
            $favorite = Favorite::firstOrCreate(['user_id' => $user->id]);

            $favoriteItem = FavoriteItem::where('favorite_id', $favorite->id)
                ->where('product_id', $productId)
                ->first();

            if ($favoriteItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã tồn tại'
                ]);
            } else {
                FavoriteItem::create([
                    'favorite_id' => $favorite->id,
                    'product_id' => $productId,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào mục yêu thích',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn cần đăng nhập để dùng chức năng này'
            ]);
        }
    }



    public function deleteToFavorite(Request $request)
    {
        $id = $request->input('id');

        $user = auth()->user();

        if ($user) {
            $favoriteItem = FavoriteItem::where('id', $id)->whereHas('favorite', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();

            if ($favoriteItem) {
                $favoriteItem->delete();

                $favoriteProductsData = $this->getFavoriteProductItemsData($user->id);

                return response()->json([
                    'success' => false,
                    'message' => 'Đã xóa sản phẩm khỏi yêu thích',
                    'favoriteItems' => $favoriteProductsData['favoriteProducts']
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Không có sản phẩm này'], 404);
        }
    }


    public function getFavoriteProductItemsData($id)
    {
        if ($id) {

            $favoriteProductItems = FavoriteItem::whereHas('favorite', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
                ->whereHas('product', function ($query) {
                    $query->where('is_active', 1)
                        ->whereHas('category', function ($query) {
                            $query->where('is_active', 1);
                        });
                })
                ->with('product.variants')
                ->get();

            $favoriteProducts = [];

            foreach ($favoriteProductItems as $item) {
                $id = $item->id;
                $product = $item->product;

                $minPrice = $product->variants->min('price_sale');
                $maxPrice = $product->variants->max('price_sale');
                $quantity = $product->variants->sum('quantity');


                $favoriteProducts[] = (object) [
                    'id' => $product->id,
                    'idFavorite' => $id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'img_thumb' => $product->img_thumb,
                    'quantity' => $quantity,
                    'is_active' => $product->is_active,
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                ];
            }

            return [
                'favoriteProducts' => $favoriteProducts,
            ];
        }
    }
}
