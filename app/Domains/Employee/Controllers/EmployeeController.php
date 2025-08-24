<?php

namespace App\Domains\Employee\Controllers;

use App\Domains\Employee\Models\Employee;
use App\Domains\Employee\Requests\StoreEmployeeRequest;
use App\Domains\Employee\Requests\UpdateEmployeeRequest;
use App\Domains\Employee\Resources\EmployeeResource;
use App\Http\Controllers\Controller;
use App\Models\TenantUser;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //
    use ApiResponse;

    public function index()
    {

        $employees = Employee::with('user')->get();

        return $this->successResponse(
            EmployeeResource::collection($employees),
            'Employees retrieved successfully'
        );
    }

    public function store(StoreEmployeeRequest $request)
    {

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

            return $this->successResponse(
                new EmployeeResource($employee),
                'Employee created successfully',
                201
            );

        });

    }

    public function update(UpdateEmployeeRequest $request, TenantUser $user)
    {

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

        return $this->successResponse(
            new EmployeeResource($user->employee),
            'Employee updated successfully'
        );
    }

    public function destroy(TenantUser $user)
    {

        $user->delete();

        return $this->successResponse(
            null,
            'Employee deleted successfully'
        );
    }
}
