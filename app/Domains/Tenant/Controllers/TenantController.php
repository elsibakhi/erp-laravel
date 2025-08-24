<?php

namespace App\Domains\Tenant\Controllers;

use App\Domains\Tenant\Models\Tenant;
use App\Domains\Tenant\Requests\StoreTenantRequest;
use App\Domains\Tenant\Requests\UpdateTenantRequest;
use App\Domains\Tenant\Resources\TenantResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class TenantController extends Controller
{
    //
    use ApiResponse;

    public function index()
    {

        $tenants = Tenant::all();

        return $this->successResponse(
            TenantResource::collection($tenants),
            'Tenants retrieved successfully'
        );
    }

    public function store(StoreTenantRequest $request)
    {
        $tenant = Tenant::create($request->all());

        return $this->successResponse(
            new TenantResource($tenant),
            'Tenant created successfully',
            201
        );
    }

    public function update(UpdateTenantRequest $request, $tenant)
    {
        $tenant = Tenant::findOrFail($tenant);
        $tenant->update($request->all());

        return $this->successResponse(
            new TenantResource($tenant),
            'Tenant updated successfully'
        );
    }

    public function destroy($tenant)
    {
        $tenant = Tenant::findOrFail($tenant);
        $tenant->delete();

        return $this->successResponse(
            null,
            'Tenant deleted successfully'
        );
    }
}
