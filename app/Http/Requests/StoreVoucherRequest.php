<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:vouchers,code',
            'discount' => 'required|integer|min:1|max:100',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'min_money' => 'required|integer|min:0|lt:max_money',
            'max_money' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher là bắt buộc',
            'code.max' => 'Mã voucher tối đa 255 kí tự',
            'code.unique' => 'Mã voucher đã tồn tại, vui lòng chọn mã khác',

            'discount.required' => 'Giá trị giảm giá là bắt buộc',
            'discount.integer' => 'Giá trị giảm giá phải là số',
            'discount.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 1',
            'discount.max' => 'Giá trị giảm giá phải nhỏ hơn hoặc bằng 100',

            'quantity.required' => 'Số lượng là bắt buộc',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải là ngày hôm nay hoặc một ngày trong tương lai',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc',

            'end_date.required' => 'Ngày kết thúc là bắt buộc',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ',
            'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',

            'min_money.required' => 'Số tiền tối thiểu là bắt buộc',
            'min_money.integer' => 'Số tiền tối thiểu phải là số',
            'min_money.min' => 'Số tiền phải lớn hơn hoặc bằng 0',
            'min_money.lt' => 'Số tiền tối thiểu phải nhỏ hơn số tiền tối đa',

            'max_money.required' => 'Số tiền tối đa là bắt buộc',
            'max_money.integer' => 'Số tiền tối đa phải là số',
            'max_money.min' => 'Số tiền phải lớn hơn hoặc bằng 0',
        ];
    }
}
