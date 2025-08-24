<?php

namespace App\Domains\Department\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:tenant.departments,name',

        ];

    }
}
