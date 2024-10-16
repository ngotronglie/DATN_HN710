<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)
        ->whereHas('creator', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->orderBy('id', 'desc')
        ->get();
        return view("client.includes.main", compact('banners'));
    }

    public function contact()
    {
        return view("");
    }
}