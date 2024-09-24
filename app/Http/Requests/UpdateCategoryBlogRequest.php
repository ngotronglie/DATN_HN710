<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryBlogRequest extends FormRequest
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
        // Lấy ID từ route
        $id = $this->route('category_blog')->id;

        return [
            'name' => 'required|string|min:3|max:255|unique:category_blogs,name,'.$id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục bài viết là bắt buộc',
            'name.string' => 'Tên danh mục bài viết phải là một chuỗi văn bản',
            'name.min' => 'Tên danh mục bài viết không được ít hơn 3 ký tự',
            'name.max' => 'Tên danh mục bài viết không được dài quá 255 ký tự',
            'name.unique' => 'Tên danh mục bài viết này đã tồn tại trong hệ thống',
        ];
    }
}
