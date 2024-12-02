<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Http\Requests\StoreCategoryBlogRequest;
use App\Http\Requests\UpdateCategoryBlogRequest;
use Illuminate\Support\Facades\Gate;

class CategoryBlogController extends Controller
{
    const PATH_VIEW = 'admin.layout.categoryBlogs.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', CategoryBlog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $data = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->whereNull('deleted_at');
            }
        ])->orderBy('id', 'DESC')->get();
        $trashedCount = CategoryBlog::onlyTrashed()->count();
        return view(self::PATH_VIEW.__FUNCTION__, compact('data', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', CategoryBlog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryBlogRequest $request)
    {
        if (Gate::denies('create', CategoryBlog::class)) {
            return redirect()->route('admin.category_blogs.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        CategoryBlog::create($data);
        return redirect()->route('admin.category_blogs.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryBlog $categoryBlog)
    {
        if (Gate::denies('view', $categoryBlog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $data = Blog::with('user', 'categoryBlog')
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('category_blog_id', $categoryBlog->id)
            ->orderBy('id', 'DESC')
            ->get();

        $blogCount = $data->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categoryBlog', 'blogCount', 'data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryBlog $categoryBlog)
    {
        if (Gate::denies('update', $categoryBlog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW.__FUNCTION__, compact('categoryBlog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryBlogRequest $request, CategoryBlog $categoryBlog)
    {
        if (Gate::denies('update', $categoryBlog)) {
            return redirect()->route('admin.category_blogs.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $categoryBlog->update($data);
        return redirect()->route('admin.category_blogs.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryBlog $categoryBlog)
    {
        if (Gate::denies('delete', $categoryBlog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $categoryBlog->delete();
        return redirect()->route('admin.category_blogs.index')->with('success', 'Xóa thành công');
    }


    public function trashed()
    {
        if (Gate::denies('viewTrashed', CategoryBlog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedCategoryBlogs = CategoryBlog::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedCategoryBlogs'));
    }

     //ajax trashedCount
     public function trashedCount()
     {
         $trashedCount = CategoryBlog::onlyTrashed()->count();
         return response()->json(['trashedCount' => $trashedCount]);
     }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $categoryBlog = CategoryBlog::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $categoryBlog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $categoryBlog->restore();
        return redirect()->route('admin.category_blogs.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $categoryBlog = CategoryBlog::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $categoryBlog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $categoryBlog->forceDelete();
        return redirect()->route('admin.category_blogs.trashed')->with('success', 'Danh mục bài viết đã xóa vĩnh viễn');
    }
}
