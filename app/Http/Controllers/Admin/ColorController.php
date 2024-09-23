<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;

class ColorController extends Controller
{
    const PATH_VIEW = 'admin.layout.colors.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->get();
        $trashedCount = Color::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('colors', 'trashedCount'));
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
    public function store(StoreColorRequest $request)
    {
        $data = $request->all();
        Color::create($data);
        return redirect()->route('colors.index')->with('success', 'Thêm thành công');
    }


    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        $data = $request->all();
        $color->update($data);
        return redirect()->route('colors.index')->with('success', 'Sửa thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('colors.index')->with('success', ' Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        $trashedColors = Color::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedColors'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->restore();
        return redirect()->route('colors.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->forceDelete();
        return redirect()->route('colors.trashed')->with('success', 'Màu đã bị xóa vĩnh viễn');
    }
}