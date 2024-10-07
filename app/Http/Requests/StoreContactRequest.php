<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',  // Trường name bắt buộc, kiểu chuỗi và không quá 255 ký tự
            'email' => 'required|email|max:255',  // Trường email bắt buộc, phải là địa chỉ email hợp lệ và không quá 255 ký tự
            'title' => 'required|string|max:255', // Trường title bắt buộc, kiểu chuỗi và không quá 255 ký tự
            'messager' => 'required|string|min:10|max:5000', // Trường message bắt buộc, kiểu chuỗi, tối thiểu 10 ký tự và tối đa 5000 ký tự
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Vui lòng cung cấp địa chỉ email hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'title.required' => 'Trường tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'messager.required' => 'Trường tin nhắn là bắt buộc.',
            'messager.min' => 'Tin nhắn phải có ít nhất 10 ký tự.',
            'messager.max' => 'Tin nhắn không được vượt quá 5000 ký tự.',

        ];
    }
}
