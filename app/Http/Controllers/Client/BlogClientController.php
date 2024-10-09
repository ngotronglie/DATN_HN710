<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\User;

class BlogClientController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user', 'category')
            ->where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);


        $hotblogs = Blog::where('is_active', 1)
            ->whereHas('category', function ($query) {
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

        return view('client.pages.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }


    public function show(Blog $blog)
    {
        $trashedCategories = CategoryBlog::onlyTrashed()->pluck('id')->toArray();
        $trashedUsers = User::onlyTrashed()->pluck('id')->toArray();

        $hotblogs = Blog::where('is_active', 1)
            ->whereHas('category', function ($query) {
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


        foreach ($trashedCategories as $idBlTrash) {
            if ($idBlTrash == $blog->category_blog_id) {
                return abort(404);
            }

        }

        foreach ($trashedUsers as $idBlTrash) {
            if ($idBlTrash == $blog->user_id) {
                return abort(404);
            }

        }

        return view('client.pages.blog-detail', compact('blog', 'hotblogs', 'categoryBlog'));
    }
}

