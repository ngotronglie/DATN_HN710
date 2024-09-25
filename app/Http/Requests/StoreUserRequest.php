<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
            'date_of_birth' => 'required|date|before:today',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc',
            'name.string' => 'Tên phải là một chuỗi ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',

            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',

            'address.required' => 'Địa chỉ là bắt buộc',
            'address.string' => 'Địa chỉ phải là một chuỗi',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và gồm 10 số',

            'avatar.required' => 'Avatar là bắt buộc',
            'avatar.image' => 'Avatar phải là một hình ảnh',
            'avatar.mimes' => 'Avatar phải có định dạng: jpeg, png, jpg, hoặc gif',
            'avatar.max' => 'Kích thước avatar không được vượt quá 2MB',

            'password.required' => 'Mật khẩu là bắt buộc',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất 1 chữ cái in hoa, 1 chữ cái thường và 1 chữ số',

            'date_of_birth.required' => 'Ngày sinh là bắt buộc',
            'date_of_birth.date' => 'Ngày sinh không đúng định dạng ngày',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay',
        ];
    }
}
