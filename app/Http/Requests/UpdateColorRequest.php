<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'hex_code' => ['required'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên màu không được để trống',
            'name.string' => 'Tên màu phải là kiểu chuỗi',
            'name.max' => 'Tên màu không quá 255 ký tự',
            'hex_code.required' => 'Mã màu HEX không được để trống',
        ];
    }
}