<?php

namespace App\Http\Requests\User\Issue;

use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

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
        $rules = [
            'status' => 'required|in:OPEN,IN_PROGRESS,ON_HOLD,SEND_FOR_REVIEW,COMPLETED',
        ];
        if (auth()->user()->hasRole(config('site.role.hr'))) {
            if ( request()->managerId) {
                return $rules;
            }
            return [
                'manager_id' => 'required|exists:users,id',
                'priority' => 'required',
                'due_date' => 'required|date|after_or_equal:today',
                'status' => 'required|in:OPEN,IN_PROGRESS,ON_HOLD,SEND_FOR_REVIEW,COMPLETED',
            ];

        }
        return $rules;
    }

    public function messages(){
        return [
            'manager_id' => 'Please assign a manager to this issue before updating status.',
        ];
    }
}
