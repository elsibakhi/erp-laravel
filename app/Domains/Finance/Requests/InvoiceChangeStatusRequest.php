<?php

namespace App\Domains\Finance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceChangeStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [

            'status' => 'required|in:paid,unpaid,overdue',

        ];

    }
}
