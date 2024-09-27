<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\Auth;
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
        $banners = Banner::orderBy('id', 'desc')->get();
        $trashedCount = Banner::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('banners', 'trashedCount'));
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
    public function store(StoreBannerRequest $request)
    {
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
        $banner->load('user');
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $data = $request->except('image');
        $data['user_id'] = Auth::id();
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            if (!empty($banner->image) && Storage::exists($banner->image)) {
                Storage::delete($banner->image);
            }
        } else {
            $data['image'] = $banner->image;
        }

        // // Gán dữ liệu mới vào model
        // $banner->fill($data);

        // // Kiểm tra nếu không có sự thay đổi
        // if ($banner->isClean()) {
        //     return redirect()->back()->with('info', 'Không có thay đổi nào được thực hiện');
        // }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        $trashedBanners = Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedBanners'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->restore();
        return redirect()->route('admin.banners.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        if ($banner->image) {
            Storage::delete($banner->image);
        }
        $banner->forceDelete();
        return redirect()->route('admin.banners.trashed')->with('success', 'Banner đã bị xóa vĩnh viễn');
    }
}
