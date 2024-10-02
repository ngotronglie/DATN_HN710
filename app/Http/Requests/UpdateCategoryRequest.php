<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $id = $this->route('category')->id; 

        return [
            'name' => 'required|string|min:3|max:255|unique:categories,name,'.$id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.min' => 'Tên danh mục không được ít hơn 3 ký tự',
            'name.max' => 'Tên danh mục không được dài quá 255 ký tự',
            'name.unique' => 'Tên danh mục này đã tồn tại trong hệ thống',
        ];
    }
}
