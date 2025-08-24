<?php

namespace App\Domains\Finance\Models;

use App\Domains\Employee\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Invoice extends Model
{
    // You can add custom methods or properties here if needed.
    use UsesTenantConnection;

    protected $fillable = [
        'employee_id',
        'invoice_number',
        'customer_name',
        'amount',
        'due_date',
        'status',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            $year = date('Y');
            $latest = self::whereYear('created_at', $year)->latest('id')->first();
            $next = $latest ? intval(substr($latest->invoice_number, -4)) + 1 : 1;
            $invoice->invoice_number = 'INV-'.$year.'-'.str_pad($next, 4, '0', STR_PAD_LEFT);
        });
    }
}
