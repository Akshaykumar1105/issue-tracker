<?php

namespace App\Http\Requests\User\Manager;

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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->manager,
            'mobile_no' => 'required|digits:10',
            'profile_img' => 'nullable|mimes:jpeg,png,jpg,gif|max:4096'
        ];
    }
}
