<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    const PATH_VIEW = 'admin.layout.banners.';
    const PATH_UPLOAD = 'banners';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', Banner::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $banners = Banner::whereHas('creator', function ($query) {
            $query->whereNull('deleted_at'); // Chỉ lấy tài khoản chưa bị xóa mềm
        })->orderBy('id', 'desc')->get();
        $trashedCount = Banner::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('banners', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Banner::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        if (Gate::denies('create', Banner::class)) {
            return redirect()->route('admin.banners.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->except('image');
        $data['user_id'] = Auth::id();
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        } else {
            $data['image'] = '';
        }
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        if (Gate::denies('view', $banner)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        if (!$banner->creator || $banner->creator->trashed()) {
            abort(404);
        }
        $banner->load(['creator', 'updater']);
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        if (Gate::denies('update', $banner)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        if (!$banner->creator || $banner->creator->trashed()) {
            abort(404);
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        if (Gate::denies('update', $banner)) {
            return redirect()->route('admin.banners.index')->with('warning', 'Bạn không có quyền!');
        }

        $data = $request->except('image');
        $data['updated_by'] = Auth::id();
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            if (!empty($banner->image) && Storage::exists($banner->image)) {
                Storage::delete($banner->image);
            }
        } else {
            $data['image'] = $banner->image;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if (Gate::denies('delete', $banner)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $banner->delete();
        return back()->with('success', 'Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        if (Gate::denies('viewTrashed', Banner::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedBanners = Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedBanners'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $banner)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $banner->restore();
        return redirect()->route('admin.banners.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $banner)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        if ($banner->image) {
            Storage::delete($banner->image);
        }
        $banner->forceDelete();
        return redirect()->route('admin.banners.trashed')->with('success', 'Banner đã bị xóa vĩnh viễn');
    }
}
