<?php

namespace App\Domains\Finance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [

            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0|max:9999999999999.99|decimal:0,2|min:0',
            'category' => 'nullable|string|max:255',
            'expense_date' => 'nullable|date|date_format:Y-m-d',
        ];

    }
}
