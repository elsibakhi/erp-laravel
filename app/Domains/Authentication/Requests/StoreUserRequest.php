<?php

namespace App\Domains\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        $connection = $this->role == 'Super Admin' ? 'landlord' : 'tenant';

        return [
            'name' => 'required|string|max:255',
            'email' => "required|string|max:255|email|unique:$connection.users,email",
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'role' => ['nullable', 'string', Rule::in(erpRoles()->flatten()->toArray())],

        ];

    }
}
