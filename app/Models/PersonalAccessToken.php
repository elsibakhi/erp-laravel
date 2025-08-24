<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumToken;

class PersonalAccessToken extends SanctumToken
{
    protected $connection = 'mysql'; // default landlord

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Detect tenant or landlord and switch DB connection
        if (app()->has('currentTenant')) {
            $this->setConnection('tenant');
        } else {
            $this->setConnection('landlord');
        }
    }
}
