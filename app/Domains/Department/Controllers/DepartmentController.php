<?php

namespace App\Domains\Department\Controllers;

use App\Domains\Department\Models\Department;
use App\Domains\Department\Requests\StoreDepartmentRequest;
use App\Domains\Department\Requests\UpdateDepartmentRequest;
use App\Domains\Department\Resources\DepartmentResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\TenantGuard;

class DepartmentController extends Controller
{
    //
    use TenantGuard;

    /**
     * Show all departments
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        authorizePermission('view departments', $this->getGuard());

        $departments = Department::paginate(10);

        return ApiResponse::success(
            DepartmentResource::collection($departments),
            'departments retrieved successfully', 200, $departments->nextPageUrl()
        );
    }

    public function store(StoreDepartmentRequest $request)
    {
        authorizePermission('store departments', $this->getGuard());
        $department = Department::create($request->validated());

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department created successfully',
            201
        );
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        authorizePermission('update departments', $this->getGuard());
        $department->update($request->validated());

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department updated successfully'
        );
    }

    public function destroy(Department $department)
    {
        authorizePermission('destroy departments', $this->getGuard());
        $department->delete();

        return ApiResponse::success(
            null,
            'Department deleted successfully'
        );
    }
}
