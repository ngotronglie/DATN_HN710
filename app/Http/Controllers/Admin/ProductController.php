<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.layout.products.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants')->orderBy('id', 'desc')->get();
        $trashedCount = Product::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->except(['variants', 'img_thumb', 'product_galleries']);
        $data['slug'] = Str::slug($data['name']);
        $uploadedFiles = [];
        if ($request->hasFile('img_thumb')) {
            $data['img_thumb'] = Storage::put('products', $request->file('img_thumb'));
        }

        try {
            DB::beginTransaction();

            // Tạo sản phẩm
            $product = Product::create($data);

            // Xử lý hình ảnh gallery nếu có
            if ($request->hasFile('product_galleries')) {
                foreach ($request->file('product_galleries') as $image) {
                    $imagePath = Storage::put('product_galleries', $image);
                    $uploadedFiles[] = $imagePath;
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                    ]);
                }
            }

            // Xử lý các biến thể nếu có
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'color_id' => $variant['color_id'],
                        ],
                        [
                            'quantity' => data_get($variant, 'quantity', 0),
                            'price' => data_get($variant, 'price', 0),
                            'price_sale' => data_get($variant, 'price_sale', 0),
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Thêm mới thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($data['img_thumb']) && Storage::exists($data['img_thumb'])) {
                Storage::delete($data['img_thumb']);
            }

            foreach ($uploadedFiles as $file) {
                if (Storage::exists($file)) {
                    Storage::delete($file);
                }
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra. Thêm mới thất bại');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['galleries', 'variants.size', 'variants.color']);
        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['variants', 'galleries']);
        $categories = Category::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'categories', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->except(['variants', 'img_thumb', 'product_galleries']);
        $data['slug'] = Str::slug($data['name']);
        $uploadedFiles = [];
        if ($request->hasFile('img_thumb')) {
            if ($product->img_thumb && Storage::exists($product->img_thumb)) {
                Storage::delete($product->img_thumb);
            }
            $data['img_thumb'] = Storage::put('products', $request->file('img_thumb'));
        }

        try {
            DB::beginTransaction();

            // Cập nhật sản phẩm
            $product->update($data);

            // Xử lý hình ảnh gallery nếu có
            if ($request->hasFile('product_galleries')) {
                // Xóa hình ảnh gallery cũ nếu cần
                $existingGalleries = $product->galleries;
                foreach ($existingGalleries as $gallery) {
                    Storage::delete($gallery->image);
                    $gallery->delete();
                }

                foreach ($request->file('product_galleries') as $image) {
                    $imagePath = Storage::put('product_galleries', $image);
                    $uploadedFiles[] = $imagePath;
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                    ]);
                }
            }

            // Xử lý các biến thể nếu có
            if ($request->has('variants')) {
                // Lấy tất cả các biến thể hiện tại của sản phẩm
                $existingVariants = $product->variants->keyBy(function ($variant) {
                    return $variant->size_id . '-' . $variant->color_id;
                });

                foreach ($request->variants as $variant) {
                    $variantKey = $variant['size_id'] . '-' . $variant['color_id'];

                    // Cập nhật hoặc tạo mới biến thể
                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'color_id' => $variant['color_id'],
                        ],
                        [
                            'quantity' => !empty($variant['quantity']) ? $variant['quantity'] : 0,
                            'price' => !empty($variant['price']) ? $variant['price'] : 0,
                            'price_sale' => !empty($variant['price_sale']) ? $variant['price_sale'] : 0,
                        ]
                    );

                    // Xóa biến thể đã tồn tại nhưng không có trong dữ liệu gửi lên (request)
                    if ($existingVariants->has($variantKey)) {
                        $existingVariants->forget($variantKey);
                    }
                }

                // Xóa các biến thể trong csdl mà ko có trong request
                foreach ($existingVariants as $variant) {
                    $variant->delete();
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Sửa thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($data['img_thumb'])) {
                Storage::delete($data['img_thumb']);
            }

            foreach ($uploadedFiles as $file) {
                Storage::delete($file);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra. Sửa thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Xóa thành công');
    }

    /**
     * Hiển thị danh sách danh mục đã bị xóa mềm.
     */
    public function trashed()
    {
        $trashedProducts = Product::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view(self::PATH_VIEW . 'trashed', compact('trashedProducts'));
    }

    /**
     * Khôi phục danh mục đã bị xóa mềm.
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trashed')->with('success', 'Khôi phục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục đã bị xóa mềm.
     */
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->img_thumb) {
            Storage::delete($product->img_thumb);
        }

        $galleries = $product->galleries;
        foreach ($galleries as $gallery) {
            if ($gallery->image) {
                Storage::delete($gallery->image);
            }
        }

        $product->forceDelete();
        return redirect()->route('admin.products.trashed')->with('success', 'Sản phẩm đã bị xóa vĩnh viễn');
    }
}
