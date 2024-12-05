<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget('user_cart');

        $banners = Banner::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Lượt xem sản phẩm
        $productViews = Product::where('is_active', '1')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->with(['galleries', 'variants'])
            ->orderByDesc('view')
            ->get();

        // Sản phẩm mới nhất
        $newProducts = Product::where('is_active', '1')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->with([
                'galleries',
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
                }
            ])
            ->orderBy('id', 'desc')
            ->get();

        // Sản phẩm bán chạy nhất
        $bestSellingProducts = Product::where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->withSum(['variants as total_sold' => function ($query) {
                $query->join('order_details', 'order_details.product_variant_id', '=', 'product_variants.id')
                    ->join('orders', 'orders.id', '=', 'order_details.order_id') // Kết nối với bảng orders
                    ->where('orders.status', 4); // Chỉ tính các đơn hàng có status = 4;
            }], 'order_details.quantity')
            ->with(['galleries', 'variants' => function ($query) {
                $query->whereHas('size', function ($query) {
                    $query->whereNull('deleted_at');
                })
                    ->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
            }])
            ->having('total_sold', '>', 0)
            ->orderByDesc('total_sold')
            ->get();

        return view("client.includes.main", compact('banners', 'productViews', 'newProducts', 'bestSellingProducts'));
    }
}
