<?php

namespace App\Domains\Department\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Department extends Model
{
    use UsesTenantConnection;

    protected $fillable = [
        'name',
    ];
}
