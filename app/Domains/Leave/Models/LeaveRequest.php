<?php

namespace App\Domains\Leave\Models;

use App\Domains\Employee\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class LeaveRequest extends Model
{
    // You can add custom methods or properties here if needed.
    use UsesTenantConnection;

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
