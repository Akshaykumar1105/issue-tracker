<?php

namespace App\Http\Requests\Admin\DiscountCoupon;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'code' => 'required|unique:discount_coupons,code',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:FLAT,VARIABLE|max:'.(request()->discount_type == 'FLAT' ? '2000' : '100'),
            'active_at' => 'nullable|date',
            'expire_at' => 'nullable|date',
            'is_active' => 'required|in:0,1',
        ];
    }
}
