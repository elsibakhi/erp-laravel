<?php

namespace App\Domains\Employee\Controllers;

use App\Domains\Employee\Models\Employee;
use App\Domains\Employee\Requests\StoreEmployeeRequest;
use App\Domains\Employee\Requests\UpdateEmployeeRequest;
use App\Domains\Employee\Resources\EmployeeResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\TenantUser;
use App\Traits\TenantGuard;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //
    use TenantGuard;

    public function index()
    {
        authorizePermission('view employees', $this->getGuard());
        $employees = Employee::with('department')->paginate(10);

        return ApiResponse::success(
            EmployeeResource::collection($employees),
            'Employees retrieved successfully', 200, $employees->nextPageUrl()
        );
    }

    public function store(StoreEmployeeRequest $request)
    {
        authorizePermission('store employees', $this->getGuard());

        return DB::transaction(function () use ($request) {

            $user = TenantUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $employee = $user->employee()->create([
                'phone' => $request->phone,
                'job_title' => $request->job_title,
                'department_id' => $request->department_id,
                'hire_date' => $request->hire_date,
                'salary' => $request->salary,
                'status' => $request->status,
            ]);

            return ApiResponse::success(
                new EmployeeResource($employee),
                'Employee created successfully',
                201
            );

        });

    }

    public function update(UpdateEmployeeRequest $request, TenantUser $user)
    {
        authorizePermission('update employees', $this->getGuard());
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->employee->update([
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'department_id' => $request->department_id,
            'hire_date' => $request->hire_date,
            'salary' => $request->salary,
            'status' => $request->status,
        ]);

        return ApiResponse::success(
            new EmployeeResource($user->employee),
            'Employee updated successfully'
        );
    }

    public function destroy(TenantUser $user)
    {
        authorizePermission('destroy employees', $this->getGuard());
        $user->delete();

        return ApiResponse::success(
            null,
            'Employee deleted successfully'
        );
    }
}
