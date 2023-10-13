<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Profile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = auth()->user()->id;   
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|digits:10',
        ];
    }
}
