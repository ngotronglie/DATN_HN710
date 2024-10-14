<?php

namespace App\Http\Requests;

use App\Models\CategoryBlog;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:blogs,title',
            'content' => 'required|string',
            'category_blog_id' => 'required|integer|exists:category_blogs,id',
            'img_avt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Kiểm tra nếu danh mục có `is_active = 1`
            $category = CategoryBlog::where('id', $this->category_blog_id)
                ->where('is_active', 1)
                ->first();

            if (!$category) {
                $validator->errors()->add('category_blog_id', 'Danh mục bài viết không hợp lệ hoặc đã bị vô hiệu hóa');
            }
        });
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'title.unique' => 'Tiêu đề đã tồn tại',

            'content.required' => 'Nội dung là bắt buộc',

            'category_blog_id.required' => 'ID danh mục bài viết là bắt buộc',
            'category_blog_id.integer' => 'ID danh mục phải là số nguyên',
            'category_blog_id.exists' => 'ID danh mục không tồn tại',

            'img_avt.required' => 'Bạn chưa chọn ảnh đại diện',
            'img_avt.image' => 'Tệp tải lên phải là một ảnh',
            'img_avt.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg, gif',
            'img_avt.max' => 'Kích thước ảnh đại diện không được vượt quá 2MB',
        ];
    }
}
