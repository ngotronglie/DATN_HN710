<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
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
            ->orderBy('blogs_count', 'DESC')
            ->get();


        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }


    public function getBlogCategory($id)
    {

        $hotblogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        $blogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) use ($id) {
                $query->whereNull('deleted_at')
                    ->where('id', $id);
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->orderBy('blogs_count', 'DESC')
            ->get();

        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }

    public function show($id)
    {
        $blogQuery = Blog::with(['categoryBlog', 'user'])
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });

        $blog = (clone $blogQuery)->findOrFail($id);

        $blog->increment('view');

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
            ->orderBy('blogs_count', 'DESC')
            ->get();


        return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog'));
    }

    public function search(Request $request)
    {
        $input = $request->input('searchBlog');

        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });


        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $blogs = $blogQuery->where(function ($query) use ($input) {
            $query->where('title', 'LIKE', "%{$input}%")
                ->orWhere('content', 'LIKE', "%{$input}%");
        })->paginate(6);

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->orderBy('blogs_count', 'DESC')
            ->get();

        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog', 'input'));
    }
}
