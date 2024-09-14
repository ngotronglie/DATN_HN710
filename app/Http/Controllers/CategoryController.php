<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.layout.categories.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $trashedCount = Category::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $data['is_active'] ??= 0;
        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->all();
        $data['is_active'] ??= 0;
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        $trashedCategories = Category::onlyTrashed()->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedCategories'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('categories.trashed')->with('success', 'Danh mục đã bị xóa vĩnh viễn');
    }
}
