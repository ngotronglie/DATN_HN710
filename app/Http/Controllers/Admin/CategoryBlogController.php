<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryBlog;
use App\Http\Requests\StoreCategoryBlogRequest;
use App\Http\Requests\UpdateCategoryBlogRequest;

class CategoryBlogController extends Controller
{
    const PATH_VIEW = 'admin.layout.categoryBlog.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CategoryBlog::orderBy('id', 'DESC')->get();
        $trashedCount = CategoryBlog::onlyTrashed()->count();
        return view(self::PATH_VIEW.__FUNCTION__, compact('data', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryBlogRequest $request)
    {
        $data = $request->all();
        CategoryBlog::create($data);
        return redirect()->route('admin.category_blogs.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryBlog $categoryBlog)
    {
        return view(self::PATH_VIEW.__FUNCTION__, compact('categoryBlog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryBlog $categoryBlog)
    {
        return view(self::PATH_VIEW.__FUNCTION__, compact('categoryBlog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryBlogRequest $request, CategoryBlog $categoryBlog)
    {
        $data = $request->all();
        $categoryBlog->update($data);
        return redirect()->route('admin.category_blogs.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryBlog $categoryBlog)
    {
        $categoryBlog->delete();
        return redirect()->route('admin.category_blogs.index')->with('success', 'Xóa thành công');
    }


    public function trashed()
    {
        $trashedCategoryBlogs = CategoryBlog::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedCategoryBlogs'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $categoryBlog = CategoryBlog::withTrashed()->findOrFail($id);
        $categoryBlog->restore();
        return redirect()->route('admin.category_blogs.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $categoryBlog = CategoryBlog::withTrashed()->findOrFail($id);
        $categoryBlog->forceDelete();
        return redirect()->route('admin.category_blogs.trashed')->with('success', 'Danh mục bài viết đã xóa vĩnh viễn');
    }
}
