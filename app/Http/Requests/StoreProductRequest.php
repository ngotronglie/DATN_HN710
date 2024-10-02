<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'img_thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Thêm validation cho biến thể
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price_sale' => 'required|numeric|min:0|lt:variants.*.price',
            'variants.*.quantity' => 'required|integer|min:1',
            // Thư viện ảnh
            'product_galleries' => 'required',
            'product_galleries.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'name.unique' => 'Tên sản phẩm đã tồn tại. Vui lòng chọn tên khác',
            'description.required' => 'Nội dung sản phẩm là bắt buộc',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại',
            'img_thumb.required' => 'Ảnh đại diện là bắt buộc',
            'img_thumb.image' => 'Ảnh đại diện phải là tệp hình ảnh',
            'img_thumb.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif, hoặc svg',
            'img_thumb.max' => 'Ảnh đại diện không được vượt quá 2MB',
            // Thư viện ảnh
            'product_galleries.required' => 'Thư viện ảnh là bắt buộc',
            'product_galleries.*.required' => 'Thư viện ảnh là bắt buộc',
            'product_galleries.*.image' => 'Tất cả các tệp trong thư viện ảnh phải là hình ảnh',
            'product_galleries.*.mimes' => 'Tất cả các tệp trong thư viện ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg',
            'product_galleries.*.max' => 'Mỗi ảnh trong thư viện không được vượt quá 2MB',
            // Thông báo lỗi cho biến thể
            'variants.*.size_id.required' => 'Kích thước là bắt buộc',
            'variants.*.size_id.exists' => 'Kích thước không hợp lệ',
            'variants.*.color_id.required' => 'Màu sắc là bắt buộc',
            'variants.*.color_id.exists' => 'Màu sắc không hợp lệ',
            'variants.*.price.required' => 'Giá là bắt buộc',
            'variants.*.price.numeric' => 'Giá phải là số',
            'variants.*.price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'variants.*.price_sale.required' => 'Giá khuyến mãi là bắt buộc',
            'variants.*.price_sale.numeric' => 'Giá khuyến mãi phải là số',
            'variants.*.price_sale.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
            'variants.*.price_sale.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'variants.*.quantity.required' => 'Số lượng là bắt buộc',
            'variants.*.quantity.integer' => 'Số lượng phải là số nguyên',
            'variants.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1',
        ];
    }
}
