<?php

namespace App\Traits;

trait LandlordGuard
{
    protected function getGuard()
    {
        return 'landlord-api';
    }
}
