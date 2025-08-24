<?php

namespace App\Domains\Project\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'end_date' => 'nullable|date|date_format:Y-m-d|after:start_date',

        ];

    }
}
