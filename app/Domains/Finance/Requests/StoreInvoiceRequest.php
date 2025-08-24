<?php

namespace App\Domains\Finance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [

            'customer_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:9999999999999.99|decimal:0,2|min:0',
            'due_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
        ];

    }
}
