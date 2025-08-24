<?php

namespace App\Domains\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        $connection = $this->routeIs('login.base')
             ? 'landlord'
             : 'tenant';

        return [

            'email' => "required|string|max:255|email|exists:$connection.users,email",
            'password' => [
                'required',
                'string', ],

        ];
    }
}
