<?php

namespace App\Http\Requests\Admin\DiscountCoupon;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|unique:discount_coupons,code,'.$this->discount_coupon.',id',
            'discount' => 'required|numeric|min:0|max:'.(request()->discount_type == 'FLAT' ? '2000' : '100'),
            'discount_type' => 'required|in:FLAT,VARIABLE',
            'active_at' => 'nullable|date',
            'expire_at' => 'nullable|date',
            'is_active' => 'required|in:0,1',
        ];
    }
}
