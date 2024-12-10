<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, [1, 2])) {
            return back()->with('warning', 'Bạn không có quyền truy cập!');
        }
        
        // Khởi tạo biến
        $monthlyRevenue = session('monthlyRevenue', collect());
        $growthRates = session('growthRates', []);
        $orderStatistics = session('orderStatistics', collect());
        $bestSellingProducts = session('bestSellingProducts', collect());
        $leastSellingProducts = session('leastSellingProducts', collect());

        return view('admin.layout.statistics.index', compact('monthlyRevenue', 'growthRates',  'orderStatistics', 'bestSellingProducts', 'leastSellingProducts'));
    }

    public function showStatistics(Request $request)
    {
        if (Auth::user()->role != 2) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $request->validate([
            'start-date' => 'required|date',
            'end-date' => 'required|date|after_or_equal:start-date',
        ], [
            'start-date.required' => 'Trường ngày bắt đầu là bắt buộc',
            'start-date.date' => 'Trường ngày bắt đầu phải là một ngày hợp lệ',
            'end-date.required' => 'Trường ngày kết thúc là bắt buộc',
            'end-date.date' => 'Trường ngày kết thúc phải là một ngày hợp lệ',
            'end-date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        $startDate = $request->input('start-date');
        $endDate = $request->input('end-date');

        if(Auth::user()->role == 1){
        
        }
        // Thống kê doanh thu trong khoảng thời gian từ ngày bắt đầu đến ngày kết thúc
        $monthlyRevenue = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as total_revenue')
            ->where('status', 4) // 4 là trạng thái hoàn tất
            ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Tính phần trăm tăng trưởng doanh thu giữa các tháng
        $growthRates = [];
        for ($i = 0; $i < count($monthlyRevenue) - 1; $i++) {
            $currentMonthRevenue = $monthlyRevenue[$i]->total_revenue;
            $previousMonthRevenue = $monthlyRevenue[$i + 1]->total_revenue;

            // Kiểm tra để tránh chia cho 0
            if ($previousMonthRevenue > 0) {
                $growthRate = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
                $growthRates[] = [
                    'month' => $monthlyRevenue[$i]->month,
                    'growth_rate' => round($growthRate, 2)
                ];
            } else {
                $growthRates[] = [
                    'month' => $monthlyRevenue[$i]->month,
                    'growth_rate' => null // Hoặc một giá trị nào đó muốn thể hiện khi không có doanh thu
                ];
            }
        }

        // Truy vấn thống kê đơn hàng
        $orderStatistics = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'), // Đếm tổng số đơn hàng
                DB::raw('SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as completed_orders'), // Đếm số đơn hàng hoàn thành
                DB::raw('SUM(CASE WHEN status = 6 THEN 1 ELSE 0 END) as canceled_orders') // Đếm số đơn hàng bị hủy
            )
            ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo khoảng thời gian
            ->groupBy('month') // Nhóm theo tháng
            ->orderByDesc('month') // Sắp xếp theo tháng giảm dần
            ->get();

        // Tổng doanh thu của tất cả các đơn hàng hoàn tất trong khoảng thời gian
        $totalRevenue = Order::where('status', 4)
            ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->sum('total_amount');

        // Thống kê sản phẩm bán chạy nhất với phần trăm đóng góp doanh thu trong khoảng thời gian
        $bestSellingProducts = OrderDetail::select('products.name as product_name', DB::raw('SUM(order_details.quantity) as total_sold'), DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'), DB::raw('ROUND(SUM(order_details.quantity * order_details.price) / ' . ($totalRevenue > 0 ? $totalRevenue : 1) . ' * 100, 2) as revenue_percentage'))
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id') // Kết nối với bảng product_variants
            ->join('products', 'product_variants.product_id', '=', 'products.id') // Kết nối với bảng products
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->whereNotNull('order_details.product_variant_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5) // Giới hạn 5 sản phẩm bán chạy nhất
            ->get();

        // Thống kê sản phẩm không bán chạy nhất với phần trăm đóng góp doanh thu trong khoảng thời gian
        $leastSellingProducts = OrderDetail::select('products.name as product_name', DB::raw('SUM(order_details.quantity) as total_sold'), DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'), DB::raw('ROUND(SUM(order_details.quantity * order_details.price) / ' . ($totalRevenue > 0 ? $totalRevenue : 1) . ' * 100, 2) as revenue_percentage'))
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id') // Kết nối với bảng product_variants
            ->join('products', 'product_variants.product_id', '=', 'products.id') // Kết nối với bảng products
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->whereNotNull('order_details.product_variant_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->groupBy('products.name')
            ->orderBy('total_sold', 'asc') // Sắp xếp theo số lượng bán giảm dần
            ->limit(5) // Giới hạn 5 sản phẩm bán ít nhất
            ->get();

        session()->flash('monthlyRevenue', $monthlyRevenue);
        session()->flash('growthRates', $growthRates);
        session()->flash('orderStatistics', $orderStatistics);
        session()->flash('bestSellingProducts', $bestSellingProducts);
        session()->flash('leastSellingProducts', $leastSellingProducts);
        session()->flash('startDate', $startDate);
        session()->flash('endDate', $endDate);

        return redirect()->route('admin.statistics.index');
    }
}
