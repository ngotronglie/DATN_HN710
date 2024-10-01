<?php

namespace App\Http\Controllers;

use Banner;
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
        return view("client.includes.main");
    }

    public function shop_danh_muc(string $id)
    {
        return view('client.pages.shop');
    }
}
