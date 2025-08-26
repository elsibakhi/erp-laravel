<?php

namespace App\Traits;

trait TenantGuard
{
    protected function getGuard()
    {
        return 'tenant-api';
    }
}
