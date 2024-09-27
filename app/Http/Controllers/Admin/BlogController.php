<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\CategoryBlog;
use Auth;

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
        $data['user_id'] = Auth::id();
            Blog::create($data);
            return redirect()->route('admin.blogs.index')->with('success', 'Thêm mới thành công');
    }



    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $ctgrbl = CategoryBlog::all();
        return view(self::PATH_VIEW.__FUNCTION__, compact('blog', 'ctgrbl'));    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $ctgrbl = CategoryBlog::all();
        return view(self::PATH_VIEW.__FUNCTION__, compact('blog', 'ctgrbl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->all();
        $blog->update($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa thành công');
    }


    public function trashed()
    {
        $trashedBlogs = Blog::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedBlogs'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $categoryBlog = Blog::withTrashed()->findOrFail($id);
        $categoryBlog->restore();
        return redirect()->route('admin.blogs.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $categoryBlog = Blog::withTrashed()->findOrFail($id);
        $categoryBlog->forceDelete();
        return redirect()->route('admin.blogs.trashed')->with('success', 'Bài viết đã xóa vĩnh viễn');
    }
}
