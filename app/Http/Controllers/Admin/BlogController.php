<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\CategoryBlog;

class BlogController extends Controller
{
    const PATH_VIEW = 'admin.layout.blog.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Blog::orderBy('id', 'DESC')->get();
        $trashedCount = Blog::onlyTrashed()->count();
        return view(self::PATH_VIEW.__FUNCTION__, compact('trashedCount', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ctgrbl = CategoryBlog::all();
        return view(self::PATH_VIEW.__FUNCTION__, compact('ctgrbl'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = 1;
        Blog::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
