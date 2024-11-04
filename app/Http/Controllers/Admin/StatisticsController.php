<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Khởi tạo biến
        $monthlyRevenue = session('monthlyRevenue', collect());
        $growthRates = session('growthRates', []);
        $bestSellingProducts = session('bestSellingProducts', collect());
        $leastSellingProducts = session('leastSellingProducts', collect());

        return view('admin.layout.statistics.index', compact('monthlyRevenue', 'growthRates', 'bestSellingProducts', 'leastSellingProducts'));
    }

    public function showStatistics(Request $request)
    {
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

        // Tổng doanh thu của tất cả các đơn hàng hoàn tất trong khoảng thời gian
        $totalRevenue = Order::where('status', 4)
            ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->sum('total_amount');

        // Thống kê sản phẩm bán chạy nhất với phần trăm đóng góp doanh thu trong khoảng thời gian
        $bestSellingProducts = OrderDetail::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as total_revenue'), DB::raw('ROUND(SUM(quantity * price) / ' . ($totalRevenue > 0 ? $totalRevenue : 1) . ' * 100, 2) as revenue_percentage'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->whereBetween('orders.created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5) // Giới hạn 5 sản phẩm bán chạy nhất
            ->get();

        // Thống kê sản phẩm không bán chạy nhất với phần trăm đóng góp doanh thu trong khoảng thời gian
        $leastSellingProducts = OrderDetail::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as total_revenue'), DB::raw('ROUND(SUM(quantity * price) / ' . ($totalRevenue > 0 ? $totalRevenue : 1) . ' * 100, 2) as revenue_percentage'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 4) // Chỉ lấy đơn hàng đã hoàn tất
            ->whereBetween('orders.created_at', [$startDate, $endDate]) // Lọc theo ngày
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc') // Sắp xếp theo số lượng bán giảm dần
            ->limit(5) // Giới hạn 5 sản phẩm bán ít nhất
            ->get();

        session()->flash('monthlyRevenue', $monthlyRevenue);
        session()->flash('growthRates', $growthRates);
        session()->flash('bestSellingProducts', $bestSellingProducts);
        session()->flash('leastSellingProducts', $leastSellingProducts);
        session()->flash('startDate', $startDate);
        session()->flash('endDate', $endDate);

        return redirect()->route('admin.statistics.index');
    }
}
