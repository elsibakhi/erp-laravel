<?php

namespace App\Domains\Project\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [
            'title' => 'required|string|max:255',
            'assigned_to' => 'nullable|integer|exists:tenant.employees,id',
            'description' => 'nullable|string|max:500',
            'due_date' => 'nullable|date|date_format:Y-m-d',
        ];

    }
}
