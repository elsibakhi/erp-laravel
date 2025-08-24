<?php

namespace App\Http\Middleware;

use App\Models\TenantPersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

class SwapConnectionToMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $connection): Response
    {

        FacadesDB::setDefaultConnection($connection);
        if ($connection === 'tenant') {

            Sanctum::usePersonalAccessTokenModel(TenantPersonalAccessToken::class);
        }

        return $next($request);
    }
}
