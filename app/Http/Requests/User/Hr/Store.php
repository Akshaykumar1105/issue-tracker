<?php

namespace App\Http\Requests\User\Hr;

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
            'name' => 'required|max:50|regex:/^[a-zA-Z]+(\s[a-zA-Z]+)?$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'password_confirmation' => 'required|same:password',
            'company_id' => 'required|not_in:default',
            'mobile' => 'required|digits:10',
        ];
    }

    public function messages(){
        return [
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ];
    }
}
