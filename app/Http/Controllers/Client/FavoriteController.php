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
            $favoriteProductData = $this->getFavoriteProductItemsData($user->id);
            $favoriteProducts = $favoriteProductData['favoriteProducts'];

            return view('client.pages.wishlist', compact('favoriteProducts'));
        } else {
            return response()->json([
                'status' => false,
                'script' => "
                swal({
                    title: 'Bạn muốn vào mục yêu thích?',
                    text: 'Bạn cần phải đăng nhập để sử dụng chức năng này!',
                    icon: 'warning',
                    buttons: {
                        cancel: 'Hủy',
                        confirm: {
                            text: 'Đăng nhập',
                            value: true,
                            visible: true,
                            className: 'swal-link-button',
                            closeModal: false
                        }
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = '/login'; // Chuyển đến trang đăng nhập
                    }
                });
            "
            ]);
        }
    }


    public function addToFavorite(Request $request)
    {
        $user = auth()->user();

        $productVariantId = $request->input('product_variant_id');

        if ($user) {
            $favorite = Favorite::firstOrCreate(['user_id' => $user->id]);

            $favoriteItem = FavoriteItem::where('favorite_id', $favorite->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($favoriteItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã tồn tại'
                ]);
            } else {
                FavoriteItem::create([
                    'favorite_id' => $favorite->id,
                    'product_variant_id' => $productVariantId,
                ]);
            }

            $favoriteProductsData = $this->getFavoriteProductItemsData($user->id);

            return response()->json([
                'message' => 'Thêm sản phẩm vào yêu thích thành công!',
                'favoriteItems' => $favoriteProductsData['favoriteProducts'],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn cần đăng nhập để dùng chức năng này!'
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
                    'message' => 'Item deleted successfully',
                    'favoriteItems' => $favoriteProductsData['favoriteProducts']
                ]);
            }

            return response()->json(['message' => 'Item not found'], 404);
        }
    }

    public function getFavoriteProductItemsData($id)
    {
        if ($id) {
            $favoriteProductItems = FavoriteItem::whereHas('favorite', function ($query) use ($id) {
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

            $groupedItems = $favoriteProductItems->groupBy('product_variant_id');

            $favoriteProducts = [];

            foreach ($groupedItems as $variantId => $items) {
                $id = $items->first()->id;
                $productVariant = $items->first()->productVariant;
                $price = $productVariant->price_sale;
                $product = $productVariant->product;
                $sizeName = $productVariant->size->name ?? '';
                $colorName = $productVariant->color->name ?? '';

                $favoriteProducts[] = (object) [
                    'id' => $id,
                    'productVariant' => $productVariant,
                    'price_sale' => $price,
                    'slug' => $product->slug,
                    'img_thumb' => $product->img_thumb,
                    'size_name' => $sizeName,
                    'color_name' => $colorName,
                ];
            }

            return [
                'favoriteProducts' => $favoriteProducts,
            ];
        }
    }
}
