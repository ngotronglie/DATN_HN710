<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Xác thực xem người dùng có quyền gửi yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng gửi yêu cầu
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_variant_id' => 'required|exists:product_variants,id', // Kiểm tra ID sản phẩm tồn tại
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    if ($value > $this->input('quantityProduct')) {
                        $fail('Số lượng phải nhỏ hơn số lượng có sẵn.');
                    }
                }
            ]
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_variant_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_variant_id.exists' => 'Sản phẩm không tồn tại.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Vui lòng nhập số!',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1!',
        ];
    }
}
