<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);


        $hotblogs = Blog::where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        $categoryBlog = CategoryBlog::where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }


    public function show($id)
    {
        $blog = Blog::with(['categoryBlog', 'user'])
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->findOrFail($id);

        $hotblogs = Blog::where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        $categoryBlog = CategoryBlog::where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->get();


        return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog'));
    }
}
