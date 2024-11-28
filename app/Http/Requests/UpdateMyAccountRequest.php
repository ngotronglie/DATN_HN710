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
            'provinces' => 'required',
            'districs' => 'required',
            'wards' => 'required',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'provinces.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'districs.required' => 'Vui lòng chọn quận/huyện.',
            'wards.required' => 'Vui lòng chọn phường/xã.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Tối đa 255 kí tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
        ];
    }
}
