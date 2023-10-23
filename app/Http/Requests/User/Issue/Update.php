<?php

namespace App\Http\Requests\User\Issue;

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
        if(auth()->user()->hasRole(config('site.role.hr'))){
            return [
                'manager_id' => 'required|exists:users,id',
                'priority' => 'required',
                'status' => 'required|in:OPEN,IN_PROGRESS,ON_HOLD,SEND_FOR_REVIEW,COMPLETED',
                'due_date' => 'required|date'
            ];
        }else{
            return [
                'status' => 'required|in:OPEN,IN_PROGRESS,ON_HOLD,SEND_FOR_REVIEW,COMPLETED',
            ];
        }
    }
}
