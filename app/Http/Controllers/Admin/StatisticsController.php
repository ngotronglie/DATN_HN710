<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Thống kê doanh thu 4 tháng gần nhất
        $monthlyRevenue = Order::selectRaw('DATE_FORMAT(order_date, "%Y-%m") as month, SUM(total_amount) as total_revenue')
            ->where('status', 4) // 4 là trạng thái hoàn tất
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(4)
            ->get();

        // Tính phần trăm tăng trưởng doanh thu giữa các tháng
        $growthRates = [];
        for ($i = 0; $i < count($monthlyRevenue) - 1; $i++) {
            $currentMonthRevenue = $monthlyRevenue[$i]->total_revenue;
            $previousMonthRevenue = $monthlyRevenue[$i + 1]->total_revenue;
            $growthRate = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
            $growthRates[] = [
                'month' => $monthlyRevenue[$i]->month,
                'growth_rate' => round($growthRate, 2)
            ];
        }

        // Thống kê danh mục có bao nhiêu sản phẩm
        $categoryStatistics = Category::select('categories.id', 'categories.name')
            ->selectRaw('COUNT(products.id) as total_products')
            ->selectRaw('MIN(product_variants.price_sale) as lowest_price')
            ->selectRaw('MAX(product_variants.price_sale) as highest_price')
            ->selectRaw('AVG(product_variants.price_sale) as average_price')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Tổng doanh thu của tất cả các đơn hàng hoàn tất
        $totalRevenue = Order::where('status', 4)->sum('total_amount');

        // Thống kê sản phẩm bán chạy nhất với phần trăm đóng góp doanh thu
        $bestSellingProducts = OrderDetail::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as total_revenue'), DB::raw('ROUND(SUM(quantity * price) / ' . $totalRevenue . ' * 100, 2) as revenue_percentage'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5) // Giới hạn 5 sản phẩm bán chạy nhất
            ->get();

        // Thống kê sản phẩm không bán chạy nhất với phần trăm đóng góp doanh thu
        $leastSellingProducts = OrderDetail::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as total_revenue'), DB::raw('ROUND(SUM(quantity * price) / ' . $totalRevenue . ' * 100, 2) as revenue_percentage'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->groupBy('product_name')
            ->orderBy('total_sold', 'asc') // Sắp xếp theo số lượng bán tăng dần
            ->limit(5) // Giới hạn 5 sản phẩm bán ít nhất
            ->get();

        return view('admin.layout.statistics.index', compact('monthlyRevenue', 'growthRates', 'categoryStatistics', 'bestSellingProducts', 'leastSellingProducts'));
    }
}
