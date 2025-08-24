<?php

namespace App\Domains\Finance\Models;

use App\Domains\Employee\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Expense extends Model
{
    // You can add custom methods or properties here if needed.
    use UsesTenantConnection;

    protected $fillable = [
        'description',
        'category',
        'amount',
        'expense_date',
        'added_by',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }
}
