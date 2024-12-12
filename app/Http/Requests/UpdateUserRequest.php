<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            
            'role' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [

            'role.required' => 'Chức vụ là bắt buộc',
            'role.in' => 'Giá trị chức vụ không hợp lệ',
        ];
    }
}
