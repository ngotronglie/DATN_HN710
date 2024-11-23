<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalRevenue = Order::where('status', 4)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $ordersCount = Order::where('status', 4)
            ->whereDate('created_at', $today)
            ->count();

        $productCount = Product::count();

        $usersCount = User::where('role', '0')->count();
        
        return view('admin.layout.yeld', compact('usersCount', 'productCount', 'ordersCount', 'totalRevenue'));
    }
}
