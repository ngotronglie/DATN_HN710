<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 4)->sum('total_amount');
        $ordersCount = Order::where('status', 4)->count();
        $productCount = Product::count();
        $usersCount = User::where('role', '0')->count();
        return view('admin.layout.yeld', compact('usersCount', 'productCount', 'ordersCount', 'totalRevenue'));
    }
}
