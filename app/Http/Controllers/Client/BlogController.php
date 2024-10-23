<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;

class BlogController extends Controller
{
    public function index()
    {
        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });

        $blogs = (clone $blogQuery)
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->having('blogs_count', '>', 0) // Điều kiện chỉ lấy danh mục có bài viết
            ->orderBy('id', 'DESC')
            ->get();


        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }


    public function getBlogCategory($id)
    {
        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) use ($id) {
                $query->whereNull('deleted_at')
                    ->where('id', $id); // Điều kiện lọc theo categoryBlog_id
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });

        $blogs = (clone $blogQuery)
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->having('blogs_count', '>', 0) // Điều kiện chỉ lấy danh mục có bài viết
            ->orderBy('id', 'DESC')
            ->get();


        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }



    public function show($id)
    {
        $blogQuery = Blog::with(['categoryBlog', 'user'])
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });

        $blog = (clone $blogQuery)->findOrFail($id);

        $viewsKey = 'blog_viewed_' . $blog->id;

        if (!session()->has($viewsKey)) {
            $blog->increment('view');
            session([$viewsKey => true]);
        }

        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->having('blogs_count', '>', 0)// chỉ lấy danh mục nếu có bài viết > 1
            ->orderBy('id', 'DESC')
            ->get();


        return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog'));
    }


}
