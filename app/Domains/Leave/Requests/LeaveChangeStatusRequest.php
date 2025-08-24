<?php

namespace App\Domains\Leave\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveChangeStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [

            'status' => 'required|in:pending,approved,rejected',

        ];

    }
}
