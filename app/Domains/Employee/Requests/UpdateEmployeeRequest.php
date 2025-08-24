<?php

namespace App\Domains\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:tenant.users,email,'.$this->route('user')->id,
            'password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'phone' => 'required|string|max:15',
            'job_title' => 'required|string|max:100',
            'department_id' => 'required|exists:tenant.departments,id',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',

        ];

    }
}
