<?php

namespace App\Http\Requests\User\Hr;

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
            'name' => 'required|max:50|regex:/^[a-zA-Z]+(\s[a-zA-Z]+)?$/',
            'email' => 'required|email|unique:users,email,'.$this->hr.',id',
            'mobile' => 'required|digits:10',
            'company_id' => 'required|exists:companies,id',
            'avatar' => 'mimes:jpeg,png,jpg,gif|max:4096'
        ];
    }
}
