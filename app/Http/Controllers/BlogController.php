<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    const PATH_VIEW = 'admin.layout.blogs.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all(); // Lấy tất cả các bài blog
        return view(self::PATH_VIEW . 'index', compact('blogs'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . 'create');
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function trashed(){
        $blogs = Blog::onlyTrashed()->get();
        return view(self::PATH_VIEW. 'trashed', compact('blogs'));
    }
}