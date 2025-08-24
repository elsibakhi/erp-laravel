<?php

namespace App\Domains\Department\Controllers;

use App\Domains\Department\Models\Department;
use App\Domains\Department\Requests\StoreDepartmentRequest;
use App\Domains\Department\Requests\UpdateDepartmentRequest;
use App\Domains\Department\Resources\DepartmentResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class DepartmentController extends Controller
{
    //
    use ApiResponse;

    public function index()
    {

        $departments = Department::paginate(10);

        return $this->successResponse(
            DepartmentResource::collection($departments),
            'departments retrieved successfully'
            , 200, $departments->nextPageUrl()
        );
    }

    public function store(StoreDepartmentRequest $request)
    {

        $department = Department::create($request->validated());

        return $this->successResponse(
            new DepartmentResource($department),
            'Department created successfully',
            201
        );
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {

        $department->update($request->validated());

        return $this->successResponse(
            new DepartmentResource($department),
            'Department updated successfully'
        );
    }

    public function destroy(Department $department)
    {

        $department->delete();

        return $this->successResponse(
            null,
            'Department deleted successfully'
        );
    }
}
