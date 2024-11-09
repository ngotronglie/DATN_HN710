<?php

// namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
// use App\Models\CartItem;
// use App\Models\Category;
// use Illuminate\Support\Facades\Auth;

// class AppServiceProvider extends ServiceProvider
// {
//     public function register(): void
//     {
//         $this->app->register(\Illuminate\Auth\AuthServiceProvider::class);
//     }


//     public function boot(): void
//     {
//         view()->composer('client/includes/header', function ($view) {
//             $view->with('clientCategories', Category::where('is_active', 1)->get());

//             if (Auth::check()) {
//                 $user = Auth::user();
//                 $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
//                     $query->where('user_id', $user->id);
//                 })
//                 ->whereHas('productVariant.product', function ($query) {
//                     $query->where('is_active', 1)
//                         ->whereHas('category', function ($query) {
//                             $query->where('is_active', 1);
//                         });
//                 })
//                 ->with('productVariant')
//                 ->get();

//                 // Nhóm các CartItem theo product_variant_id
//                 $groupedItems = $cartItems->groupBy('product_variant_id');

//                 $processedItems = [];
//                 $uniqueVariantCount = $groupedItems->count();

//                 foreach ($groupedItems as $variantId => $items) {
//                     $id = $items->first()->id;
//                     $productVariant = $items->first()->productVariant;

//                     $totalQuantity = $items->sum('quantity');
//                     $price = $productVariant->price_sale;

//                     $processedItems[] = (object) [
//                         'id' => $id,
//                         'productVariant' => $productVariant,
//                         'quantity' => $totalQuantity,
//                         'total_price' => $price * $totalQuantity,
//                     ];
//                 }

//                 $view->with('processedItems', $processedItems);
//                 $view->with('uniqueVariantCount', $uniqueVariantCount);
//             }
//         });
//     }
// }



namespace App\Providers;

use App\Models\ProductVariant;
use Illuminate\Support\ServiceProvider;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Đăng ký các service provider khác nếu cần
        $this->app->register(\Illuminate\Auth\AuthServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tạo view composer để chia sẻ dữ liệu với view
        view()->composer('client/includes/header', function ($view) {
            $view->with('clientCategories', Category::where('is_active', 1)->get());

            // Xử lý khi người dùng đã đăng nhập
            if (Auth::check()) {
                $user = Auth::user();
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

                // Nhóm các CartItem theo product_variant_id
                $groupedItems = $cartItems->groupBy('product_variant_id');

                $processedItems = [];
                $uniqueVariantCount = $groupedItems->count();

                foreach ($groupedItems as $variantId => $items) {
                    $id = $items->first()->id;
                    $productVariant = $items->first()->productVariant;

                    // Tính tổng số lượng cho từng sản phẩm variant
                    $totalQuantity = $items->sum('quantity');
                    $price = $productVariant->price_sale;

                    $processedItems[] = (object) [
                        'id' => $id,
                        'productVariant' => $productVariant,
                        'quantity' => $totalQuantity,
                        'total_price' => $price * $totalQuantity,
                    ];
                }

                // Chuyển dữ liệu vào view
                $view->with('processedItems', $processedItems);
                $view->with('uniqueVariantCount', $uniqueVariantCount);
            } else {
                // Xử lý khi người dùng chưa đăng nhập
                $sessionCart = session()->get('cart', ['items' => []]);

            $cartItems = collect($sessionCart['items'])->map(function ($item) {
                // Truy xuất thông tin sản phẩm từ cơ sở dữ liệu
                $productVariant = ProductVariant::with('product', 'size', 'color')->find($item['product_variant_id']);
                return (object) [
                    'productVariant' => $productVariant,
                    'quantity' => $item['quantity'],
                ];
            })->filter(function ($item) {
                // Lọc sản phẩm và danh mục đang hoạt động
                return $item->productVariant
                    && $item->productVariant->product->is_active
                    && $item->productVariant->product->category->is_active;
            });

            // Nhóm sản phẩm theo variant ID
            $groupedItems = $cartItems->groupBy(function ($item) {
                return $item->productVariant->id; // Sử dụng ID của productVariant để nhóm
            });

            $processedItems = [];
            $totalCartAmount = 0;

            // Duyệt qua các nhóm đã nhóm
            foreach ($groupedItems as $variantId => $items) {
                $productVariant = $items->first()->productVariant;
                $totalQuantity = $items->sum('quantity');
                $price = $productVariant->price_sale;
                $totalPriceForItem = $price * $totalQuantity;
                $totalCartAmount += $totalPriceForItem;

                $product = $productVariant->product;
                $sizeName = $productVariant->size->name ?? '';
                $colorName = $productVariant->color->name ?? '';

                $processedItems[] = (object) [
                    'id' => $variantId,
                    'productVariant' => $productVariant,
                    'quantity' => $totalQuantity,
                    'price_sale' => $price,
                    'total_price' => $totalPriceForItem,
                    'slug' => $product->slug,
                    'img_thumb' => $product->img_thumb,
                    'size_name' => $sizeName,
                    'color_name' => $colorName,
                ];
            }

            // Tính số lượng biến thể độc đáo từ processedItems
            $uniqueVariantCount = count($processedItems);


            $view->with('processedItems', $processedItems);
            $view->with('uniqueVariantCount', $uniqueVariantCount);

            }
        });
    }
}
