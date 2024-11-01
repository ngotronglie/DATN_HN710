<?php

namespace App\Providers;

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
            }
        });
    }
}
