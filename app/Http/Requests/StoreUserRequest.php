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
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'provinces' => 'required|exists:provinces,code',
            'districs' => 'required|exists:districts,code',
            'wards' => 'required|exists:wards,code',
            'work_shift_id' => 'required|exists:work_shifts,id|unique:users,work_shift_id',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'password_confirmation' => 'required',
            'date_of_birth' => 'required|date|before:today|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'name.unique' => 'Tên này đã được sử dụng',

            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',

            'provinces.required' => 'Vui lòng chọn tỉnh/thành phố',
            'districs.required' => 'Vui lòng chọn quận/huyện',
            'districs.exists' => 'Vui lòng chọn quận/huyện.',
            'wards.required' => 'Vui lòng chọn phường/xã',
            'wards.exists' => 'Vui lòng chọn phường/xã',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'provinces.exists' => 'Vui lòng chọn tỉnh/thành phố',

            'work_shift_id.required' => 'Vui lòng chọn ca làm việc.',
            'work_shift_id.exists' => 'Ca làm việc không hợp lệ.',
            'work_shift_id.unique' =>'Đã có nhân viên thuộc ca này',
            
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và gồm 10 số',

            'avatar.required' => 'Avatar là bắt buộc',
            'avatar.image' => 'Avatar phải là một hình ảnh',
            'avatar.mimes' => 'Avatar phải có định dạng: jpeg, png, jpg, webp hoặc gif',
            'avatar.max' => 'Kích thước avatar không được vượt quá 2MB',

            'password.required' => 'Mật khẩu là bắt buộc',
            'password_confirmation.required' => 'Mật khẩu là bắt buộc',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp với mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất 1 chữ cái in hoa, 1 chữ cái thường và 1 chữ số',

            'date_of_birth.required' => 'Ngày sinh là bắt buộc',
            'date_of_birth.date' => 'Ngày sinh không đúng định dạng ngày',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hiện tại',
            'date_of_birth.before_or_equal' => 'Bạn phải đủ ít nhất 18 tuổi',

        ];
    }
}
