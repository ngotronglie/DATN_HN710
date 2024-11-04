<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalRevenue = Order::where('status', 4)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');

        $ordersCount = Order::where('status', 4)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $productCount = Product::count();
        
        $usersCount = User::where('role', '0')->count();
        return view('admin.layout.yeld', compact('usersCount', 'productCount', 'ordersCount', 'totalRevenue'));
    }
}
