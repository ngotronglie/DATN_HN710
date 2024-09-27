<?php

namespace App\Http\Requests;

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
            'img_avt' => 'required|string|max:255',
        ];
    }


    public function messages()
{
    return [
        'title.required' => 'Tiêu đề là bắt buộc.',
        'title.string' => 'Tiêu đề phải là chuỗi.',
        'title.max' => 'Tiêu đề không được quá 255 ký tự.',
        'title.unique' => 'Tiêu đề đã tồn tại.',

        'content.required' => 'Nội dung là bắt buộc.',
        'content.string' => 'Nội dung phải là chuỗi.',

        'category_blog_id.required' => 'ID danh mục bài viết là bắt buộc.',
        'category_blog_id.integer' => 'ID danh mục phải là số nguyên.',
        'category_blog_id.exists' => 'ID danh mục không tồn tại.',

        'img_avt.required' => 'Ảnh đại diện là bắt buộc.',
        'img_avt.string' => 'Ảnh đại diện phải là chuỗi.',
        'img_avt.max' => 'Đường dẫn ảnh không được quá 255 ký tự.',
    ];
}
}
