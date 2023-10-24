<?php

namespace App\Http\Requests\Admin\Coupon;

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
            'code' => 'required|unique:coupons,code',
            'discount' => 'required|numeric|min:0'.(request()->discount_type == 'FLAT' ? '' : '|max:100'),
            'discount_type' => 'required|in:FLAT,VARIABLE',
            'active_at' => 'date|after_or_equal:today',
            'expire_at' => 'date|after:active_at',
            'is_active' => 'required|in:0,1',
        ];
    }
}

    