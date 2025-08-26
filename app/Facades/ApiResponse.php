<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'apiresponse'; // the name we bound in AppServiceProvider
    }
}
