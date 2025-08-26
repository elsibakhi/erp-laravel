<?php

namespace App\Domains\Tenant\Controllers;

use App\Domains\Tenant\Models\Tenant;
use App\Domains\Tenant\Requests\StoreTenantRequest;
use App\Domains\Tenant\Requests\UpdateTenantRequest;
use App\Domains\Tenant\Resources\TenantResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\LandlordGuard;

class TenantController extends Controller
{
    //
    use LandlordGuard;

    public function index()
    {
        authorizePermission('view tenants', $this->getGuard());
        $tenants = Tenant::paginate(10);

        return ApiResponse::success(
            TenantResource::collection($tenants),
            'Tenants retrieved successfully', 200, $tenants->nextPageUrl()
        );
    }

    public function store(StoreTenantRequest $request)
    {
        authorizePermission('store tenants', $this->getGuard());
        $tenant = Tenant::create($request->all());

        return ApiResponse::success(
            new TenantResource($tenant),
            'Tenant created successfully',
            201
        );
    }

    public function update(UpdateTenantRequest $request, $tenant)
    {
        authorizePermission('update tenants', $this->getGuard());
        $tenant = Tenant::findOrFail($tenant);
        $tenant->update($request->all());

        return ApiResponse::success(
            new TenantResource($tenant),
            'Tenant updated successfully'
        );
    }

    public function destroy($tenant)
    {
        authorizePermission('destroy tenants', $this->getGuard());
        $tenant = Tenant::findOrFail($tenant);
        $tenant->delete();

        return ApiResponse::success(
            null,
            'Tenant deleted successfully'
        );
    }
}
