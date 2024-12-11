<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:colors,name|regex:/^[a-zA-Z\s]+$/',
            'hex_code' => 'required|regex:/^#[0-9A-Fa-f]{6}$/|unique:colors,hex_code',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên màu là bắt buộc',
            'name.max' => 'Tên màu không được dài quá 255 ký tự',
            'name.unique' => 'Tên màu này đã tồn tại trong hệ thống',
            'name.regex' => 'Tên màu chỉ được phép chứa chữ cái',

            'hex_code.required' => 'Mã màu là bắt buộc',
            'hex_code.regex' => 'Mã màu phải phù hợp với định dạng mã màu hex (ví dụ: #FF5733)',
            'hex_code.unique' => 'Mã màu này đã tồn tại trong hệ thống',
        ];
    }
}
