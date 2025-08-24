<?php

namespace App\Domains\Tenant\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [

            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:tenants,domain,'.$this->route('tenant'),
            'database' => 'required|string|max:255|unique:tenants,database,'.$this->route('tenant'),

        ];

    }
}
