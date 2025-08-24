<?php

namespace App\Domains\Tenant\Models;

use Spatie\Multitenancy\Models\Tenant as BaseTenantModel;

class Tenant extends BaseTenantModel
{
    // You can add custom methods or properties here if needed.

    protected $fillable = [
        'name',
        'domain',
        'database',
    ];
}
