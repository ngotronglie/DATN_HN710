<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Gate;

class SizeController extends Controller
{
    const PATH_VIEW = 'admin.layout.sizes.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', Size::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $sizes = Size::orderBy('id', 'desc')->get();
        $trashedCount = Size::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('sizes', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Size::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        if (Gate::denies('create', Size::class)) {
            return redirect()->route('admin.sizes.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        Size::create($data);
        return redirect()->route('admin.sizes.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        if (Gate::denies('view', $size)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        if (Gate::denies('update', $size)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        if (Gate::denies('update', $size)) {
            return redirect()->route('admin.sizes.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $size->update($data);
        return redirect()->route('admin.sizes.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        if (Gate::denies('delete', $size)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        // Xóa mềm kích thước
        $size->delete();

        // Lấy tất cả các sản phẩm có biến thể liên quan đến kích thước này
        $products = ProductVariant::where('size_id', $size->id)->pluck('product_id')->unique();

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

            // Nếu không còn biến thể, cập nhật is_active về 0
            if ($remainingVariants == 0) {
                $product = Product::find($productId);
                $product->is_active = 0;
                $product->save();
            }
        }

        return redirect()->route('admin.sizes.index')->with('success', 'Xóa thành công');
    }


    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        if (Gate::denies('viewTrashed', Size::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedSizes = Size::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedSizes'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        // Khôi phục kích thước đã bị xóa mềm
        $size = Size::withTrashed()->findOrFail($id);
        if (Gate::denies('restore', $size)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $size->restore();

        // Lấy tất cả các sản phẩm có biến thể liên quan đến kích thước này
        $products = ProductVariant::where('size_id', $size->id)->pluck('product_id')->unique();

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

        return redirect()->route('admin.sizes.index')->with('success', 'Khôi phục thành công!');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        if (Gate::denies('forceDelete', $size)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $size->forceDelete();
        return redirect()->route('admin.sizes.trashed')->with('success', 'Size đã bị xóa vĩnh viễn');
    }
}
