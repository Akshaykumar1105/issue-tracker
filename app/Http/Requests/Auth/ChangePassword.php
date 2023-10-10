<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            'old_password' => 'required|min:8',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])/i',
                'regex:/^(?=.*[A-Z])/i',
                'regex:/^(?=.*\d)/',
                'regex:/^(?=.*[@$!%*?&])/',
                'confirmed',
            ],
            'password_confirmation' => 'required|min:8|same:password'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password must include:',
            'password.regex.0' => 'At least one letter (case-insensitive)',
            'password.regex.1' => 'At least one uppercase letter (case-insensitive)',
            'password.regex.2' => 'At least one digit',
            'password.regex.3' => 'At least one special character',
        ];
    }
}
