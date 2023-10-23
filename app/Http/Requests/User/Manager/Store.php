<?php

namespace App\Http\Requests\User\Manager;

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
        $rules =  [
            'name' => 'required|max:255|regex:/^[a-zA-Z]+(\s[a-zA-Z]+)?$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/',
            'password_confirmation' => 'required|same:password',
            'mobile' => 'required|digits:10',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif|max:4096',

        ];

        if (auth()->user()->hasRole(config('site.role.admin'))) {
            $rules . [
                'company_id' => 'required|exists:companies,id',
                'hr_id' => 'required|exists:users,id',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ];
    }
}
