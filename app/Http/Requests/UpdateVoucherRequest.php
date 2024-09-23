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
        // Lấy ID từ route
        $id = $this->route('voucher')->id;

        return [
            'code' => 'required|string|max:255|unique:vouchers,code,'.$id,
            'discount' => 'required|numeric|min:0|max:100',
            'quantity' => 'required|integer',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:end_date',
            'end_date' => 'required|date',
            'min_money' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher là bắt buộc',
            'code.string' => 'Mã voucher phải là 1 chuỗi',
            'code.max' => 'Mã voucher tối đa 255 kí tự',
            'code.unique' => 'Mã voucher đã tồn tại, vui lòng chọn mã khác',

            'discount.required' => 'Giá trị giảm giá là bắt buộc',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'discount.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 0',
            'discount.max' => 'Giá trị giảm giá phải nhỏ hơn hoặc bằng 100',

            'quantity.required' => 'Số lượng là bắt buộc',
            'quantity.integer' => 'Số lượng phải là số nguyên',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải là ngày hôm nay hoặc một ngày trong tương lai',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc',

            'end_date.required' => 'Ngày kết thúc là bắt buộc',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ',

            'min_money.required' => 'Số tiền tối thiểu là bắt buộc',
            'min_money.numeric' => 'Số tiền tối thiểu phải là số',
        ];
    }
}
