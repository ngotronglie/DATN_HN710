<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\CategoryBlog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{
    const PATH_VIEW = 'admin.layout.blogs.';

    public function index()
    {
        if (Gate::denies('viewAny', Blog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $data = Blog::with('user', 'categoryBlog')
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $trashedCount = Blog::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('trashedCount', 'data'));
    }

    public function create()
    {
        if (Gate::denies('create', Blog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $ctgrbl = CategoryBlog::where('is_active', 1)->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('ctgrbl'));
    }

    public function store(StoreBlogRequest $request)
    {
        if (Gate::denies('create', Blog::class)) {
            return redirect()->route('admin.blogs.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $data['user_id'] = Auth::id();
        if ($request->hasFile('img_avt')) {
            $data['img_avt'] = Storage::put('blogs', $request->file('img_avt'));
        } else {
            $data['img_avt'] = '';
        }
        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Thêm mới thành công');
    }



    public function show(Blog $blog)
    {
        if (Gate::denies('view', $blog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        if (!$blog->categoryBlog) {
            abort(404);
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('blog'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if (Gate::denies('update', $blog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        if (!$blog->categoryBlog) {
            abort(404);
        }
        
        $ctgrbl = CategoryBlog::where('is_active', 1)
        ->orWhere('id', $blog->category_blog_id)
        ->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('blog', 'ctgrbl'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if (Gate::denies('update', $blog)) {
            return redirect()->route('admin.blogs.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->except('img_avt');

        if ($request->hasFile('img_avt')) {
            if ($blog->img_avt && Storage::exists($blog->img_avt)) {
                Storage::delete($blog->img_avt);
            }

            $data['img_avt'] = Storage::put('blogs', $request->file('img_avt'));
        } else {
            $data['img_avt'] = $blog->img_avt;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (Gate::denies('delete', $blog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa thành công');
    }


    public function trashed()
    {
        if (Gate::denies('viewTrashed', Blog::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedBlogs = Blog::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedBlogs'));
    }

    //ajax trashedCount
    public function trashedCount()
    {
        $trashedCount = Blog::onlyTrashed()->count();
        return response()->json(['trashedCount' => $trashedCount]);
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $blog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $blog->restore();
        return redirect()->route('admin.blogs.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $blog)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $blog->forceDelete();
        return redirect()->route('admin.blogs.trashed')->with('success', 'Bài viết đã xóa vĩnh viễn');
    }
}
