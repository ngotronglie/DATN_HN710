<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->get();
        return view('admin.layout.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layout.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();

        // dd($validatedData);

        // Tạo một đối tượng Color mới và lưu vào database
        $color = Color::create($validatedData);

        // Chuyển hướng người dùng về trang index với thông báo thành công
        return redirect()->route('color.index')->with('success', 'Màu đã được tạo thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.layout.colors.edit', compact('color'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();

        // Cập nhật thông tin của đối tượng Color trong database
        $color->update($validatedData);

        // Chuyển hướng về trang index với thông báo thành công
        return redirect()->route('color.index')->with('success', 'Màu đã được cập nhật thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('color.index')->with('success', ' Color deleted successfully.');
    }
}