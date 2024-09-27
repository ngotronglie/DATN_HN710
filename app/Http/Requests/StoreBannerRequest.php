<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255|unique:banners,title',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'required|url|max:255',
            'description' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề banner là bắt buộc',
            'title.string' => 'Tiêu đề banner phải là một chuỗi văn bản',
            'title.min' => 'Tiêu đề banner không được ít hơn 3 ký tự',
            'title.max' => 'Tiêu đề banner không được dài quá 255 ký tự',
            'title.unique' => 'Tiêu đề banner này đã tồn tại trong hệ thống',

            'image.required' => 'Hình ảnh banner là bắt buộc',
            'image.image' => 'Tệp tải lên phải là một hình ảnh',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',

            'link.required' => 'Liên kết là bắt buộc',
            'link.url' => 'Liên kết phải là một URL hợp lệ',
            'link.max' => 'Liên kết không được dài quá 255 ký tự',

            'description.required' => 'Mô tả là bắt buộc',
            'description.string' => 'Mô tả phải là một chuỗi văn bản',
            'description.max' => 'Mô tả không được dài quá 500 ký tự',
        ];
    }
}
