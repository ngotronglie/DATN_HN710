<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Gate;

class ColorController extends Controller
{
    const PATH_VIEW = 'admin.layout.colors.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', Color::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $colors = Color::orderBy('id', 'desc')->get();
        $trashedCount = Color::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('colors', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Color::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        if (Gate::denies('create', Color::class)) {
            return redirect()->route('admin.colors.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        Color::create($data);
        return redirect()->route('admin.colors.index')->with('success', 'Thêm thành công');
    }


    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        if (Gate::denies('view', $color)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        if (Gate::denies('update', $color)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        if (Gate::denies('update', $color)) {
            return redirect()->route('admin.colors.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $color->update($data);
        return redirect()->route('admin.colors.index')->with('success', 'Sửa thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        if (Gate::denies('delete', $color)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }


        $productCount = ProductVariant::whereNotNull('color_id')->where('')->count();

        dd($productCount);
        // Xóa mềm màu
        $color->delete();

        // Lấy tất cả các sản phẩm có biến thể liên quan đến màu này
        $products = ProductVariant::where('color_id', $color->id)->pluck('product_id')->unique();

        foreach ($products as $productId) {
            // Kiểm tra còn lại các biến thể của sản phẩm
            $remainingVariants = ProductVariant::where('product_id', $productId)
                ->whereHas('color', function ($query) {
                    $query->whereNull('deleted_at'); // Kiểm tra các màu chưa bị xóa mềm
                })
                ->whereHas('size', function ($query) { // Kiểm tra cả kích thước chưa bị xóa mềm
                    $query->whereNull('deleted_at');
                })
                ->count();
            if ($remainingVariants == 0) {
                // Nếu không còn biến thể, cập nhật is_active về 0
                $product = Product::find($productId);
                $product->is_active = 0;
                $product->save();
            }
        }

        return redirect()->route('admin.colors.index')->with('success', 'Xóa thành công');
    }



    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        if (Gate::denies('viewTrashed', Color::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedColors = Color::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedColors'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        // Khôi phục màu đã bị xóa mềm
        $color = Color::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $color)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $color->restore();

        // Lấy tất cả các sản phẩm có biến thể liên quan đến màu này
        $products = ProductVariant::where('color_id', $color->id)->pluck('product_id')->unique();

        foreach ($products as $productId) {
            // Kiểm tra có còn biến thể nào khác (bao gồm cả màu và kích thước) không bị xóa mềm
            $remainingVariants = ProductVariant::where('product_id', $productId)
                ->whereHas('color', function ($query) {
                    $query->whereNull('deleted_at'); // Kiểm tra màu chưa bị xóa mềm
                })
                ->orWhereHas('size', function ($query) { // Kiểm tra kích thước chưa bị xóa mềm
                    $query->whereNull('deleted_at');
                })
                ->count();

            if ($remainingVariants > 0) {
                // Nếu có biến thể, bật lại trạng thái is_active cho sản phẩm
                $product = Product::find($productId);
                $product->is_active = 1;
                $product->save();
            }
        }

        return redirect()->route('admin.colors.index')->with('success', 'Khôi phục thành công!');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $color)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $color->forceDelete();
        return redirect()->route('admin.colors.trashed')->with('success', 'Màu đã bị xóa vĩnh viễn');
    }
}
