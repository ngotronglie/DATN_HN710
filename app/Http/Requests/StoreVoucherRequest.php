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
        'code' => 'required|string|max:255',
        'discount' => 'required|numeric',
        'quantity' => 'required|integer',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'min_money' => 'required|numeric',
        // 'max_money' => 'required|numeric',
        // 'is_active' => 'required|boolean',
    ];
}

}