<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Hoặc kiểm tra quyền của người dùng nếu cần
    }

    public function rules()
    {
        return [
            'provinces' => 'required|exists:provinces,code', // Tỉnh/thành phố phải tồn tại trong bảng provinces
            'districs' => 'required|exists:districts,code',   // Quận/huyện phải tồn tại trong bảng districs
            'wards' => 'required|exists:wards,code',         // Phường/xã phải tồn tại trong bảng wards
            'address' => 'required|string|max:255',        // Địa chỉ tối đa 255 ký tự
            'phone' => [
                'required',
                'string',
                'regex:/^(0|\+84)[0-9]{9}$/', // Số điện thoại bắt đầu bằng 0 hoặc +84 và dài 10 chữ số
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ảnh đại diện 
            'date_of_birth' => 'required|date|before:today',
        ];
    }

    public function messages()
    {
        return [
            'provinces.required' => 'Vui lòng chọn tỉnh/thành phố',
            'provinces.exists' => 'Vui lòng chọn tỉnh/thành phố',
            'districs.required' => 'Vui lòng chọn quận/huyện',
            'districs.exists' => 'Vui lòng chọn quận/huyện.',
            'wards.required' => 'Vui lòng chọn phường/xã',
            'wards.exists' => 'Vui lòng chọn phường/xã',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 0 hoặc +84 và bao gồm 10 chữ số.',
            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
            'date_of_birth.required' => 'Ngày sinh là bắt buộc.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
            'date_of_birth.before' => 'Ngày sinh không được là ngày hiện tại.',
        ];
    }
}
