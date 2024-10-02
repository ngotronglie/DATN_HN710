<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
    // Lấy ID của blog hiện tại từ route parameters
    $blogId = $this->route('blog')->id;

    return [
        'title' => 'required|string|max:255|unique:blogs,title,' . $blogId, // Chỉnh sửa ở đây
        'content' => 'required|string',
        'category_blog_id' => 'required|integer|exists:category_blogs,id',
        'img_avt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Thay đổi bắt buộc thành nullable
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

            'img_avt.required' => 'Bạn chưa chọn ảnh đại diện.',
            'img_avt.image' => 'Tệp tải lên phải là một ảnh.',
            'img_avt.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg, gif.',
            'img_avt.max' => 'Kích thước ảnh đại diện không được vượt quá 2MB.',
        ];
    }
}
