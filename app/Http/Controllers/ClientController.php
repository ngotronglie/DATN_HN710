<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function shop()
    {
        return view('client.pages.shop');
    }
    public function banner()
    {

        return view("");
    }
    public function contact()
    {
        return view("");
    }
    public function index()
    {
        $banners = Banner::where('is_active', 1)->get();
        return view("client.includes.main", compact('banners'));
    }

    public function shop_danh_muc(string $id)
    {
        return view('client.pages.shop');
    }
}