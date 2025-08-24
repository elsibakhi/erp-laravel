<?php

namespace App\Domains\Employee\Models;

use App\Domains\Department\Models\Department;
use App\Models\TenantUser;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Employee extends Model
{
    // You can add custom methods or properties here if needed.
    use UsesTenantConnection;

    protected $fillable = [
        'phone',
        'job_title',
        'user_id',
        'department_id',
        'hire_date',
        'salary',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
