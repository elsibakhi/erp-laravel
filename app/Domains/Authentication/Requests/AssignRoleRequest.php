<?php

namespace App\Domains\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [

            'role' => ['required', 'string', Rule::in(erpRoles()->pluck('name')->toArray())],

        ];

    }
}
