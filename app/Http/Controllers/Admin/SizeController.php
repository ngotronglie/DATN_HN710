<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;

class SizeController extends Controller
{
    const PATH_VIEW = 'admin.layout.sizes.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->get();
        $trashedCount = Size::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('sizes', 'trashedCount'));
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
    public function store(StoreSizeRequest $request)
    {
        $data = $request->all();
        Size::create($data);
        return redirect()->route('sizes.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $data = $request->all();
        $size->update($data);
        return redirect()->route('sizes.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return back()->with('success', 'Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        $trashedSizes = Size::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedSizes'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        $size->restore();
        return redirect()->route('sizes.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        $size->forceDelete();
        return redirect()->route('sizes.trashed')->with('success', 'Size đã bị xóa vĩnh viễn');
    }
}
