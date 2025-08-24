<?php

namespace App\Domains\Leave\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {

        return [
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'leave_type' => 'required|in:annual,sick,unpaid',
            'reason' => 'nullable|string|max:500',
        ];

    }
}
