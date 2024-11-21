<?php
namespace App\Providers;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\View;
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

                $groupedItems = $cartItems->groupBy('product_variant_id');

                $processedItems = [];
                $uniqueVariantCount = $groupedItems->count();

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

                $view->with('processedItems', $processedItems);
                $view->with('uniqueVariantCount', $uniqueVariantCount);
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

                $uniqueVariantCount = count($processedItems);

                $view->with('processedItems', $processedItems);
                $view->with('uniqueVariantCount', $uniqueVariantCount);

            }
        });

        View::composer('admin.include.header', function ($view) {
            $user = Auth::user();

            if ($user) {
                $notifications = $user->notifications()->orderBy('id', 'desc')->take(10)->get();
                $unreadNotifications = $user->unreadNotifications()->get();
            }else{
                $notifications = collect();
                $unreadNotifications = collect();
            }

            $view->with([
                'notifications' => $notifications,
                'unreadNotifications' => $unreadNotifications,
            ]);
        });


    }
}
