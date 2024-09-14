<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
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
    public function rules()
    {
        return [
            'code' => 'required|string|max:255', // Mã voucher không cần kiểm tra duy nhất vì bạn có thể cập nhật mã cho cùng một voucher
            'discount' => 'required|numeric|min:0|max:100', // Discount phải là số và nằm trong khoảng từ 0 đến 100
            'quantity' => 'required|integer', // Quantity phải là số nguyên
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:end_date', // Ngày bắt đầu phải là ngày hiện tại hoặc trong tương lai và <= ngày kết thúc
            'end_date' => 'required|date', // Ngày kết thúc phải là ngày
            'min_money' => 'required|numeric', // Min_money phải là số
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher là bắt buộc.',
            'discount.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount.numeric' => 'Giá trị giảm giá phải là số.',
            'discount.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 0.',
            'discount.max' => 'Giá trị giảm giá phải nhỏ hơn hoặc bằng 100.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải là ngày hôm nay hoặc một ngày trong tương lai.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
            'min_money.required' => 'Số tiền tối thiểu là bắt buộc.',
            'min_money.numeric' => 'Số tiền tối thiểu phải là số.',
        ];
    }
}