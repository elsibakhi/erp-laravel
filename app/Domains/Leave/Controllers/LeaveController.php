<?php

namespace App\Domains\Leave\Controllers;

use App\Domains\Leave\Models\LeaveRequest;
use App\Domains\Leave\Requests\LeaveChangeStatusRequest;
use App\Domains\Leave\Requests\StoreLeaveRequest;
use App\Domains\Leave\Resources\LeaveResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class LeaveController extends Controller
{
    //
    use ApiResponse;

    /**
     * list leave requests for admin
     *
     * @return JsonResponse
     */
    public function adminLeaveRequestsList()
    {

        $leave_requests = LeaveRequest::with('employee')->get();

        return $this->successResponse(
            LeaveResource::collection($leave_requests),
            'Leave requests retrieved successfully'
        );
    }

    /**
     * list leave requests for a specific authenticated employee
     *
     * @return JsonResponse
     */
    public function employeeLeaveRequestsList()
    {

        $employee = auth()->guard('tenant-api')->user();
        $leave_requests = LeaveRequest::with('employee')->where('employee_id', $employee->id)->get();

        return $this->successResponse(
            LeaveResource::collection($leave_requests),
            'Leave requests retrieved successfully'
        );
    }

    /**
     * store leave request from employee
     *
     * @return JsonResponse
     */
    public function store(StoreLeaveRequest $request)
    {

        $request_data = $request->validated();
        $server_made_data = [
            'employee_id' => auth()->guard('tenant-api')->id(),

        ];

        $leave_data = array_merge($request_data, $server_made_data);

        $leave_request = LeaveRequest::create($leave_data);

        return $this->successResponse(
            new LeaveResource($leave_request),
            'Leave request created successfully',
            201
        );

    }

    /**
     * update leave request from employee
     *
     * @return JsonResponse
     */
    public function update(StoreLeaveRequest $request, LeaveRequest $leave)
    {

        $leave->update($request->validated());

        return $this->successResponse(
            new LeaveResource($leave),
            'Leave request updated successfully'
        );
    }

    /**
     * change the status of leave request from admin
     *
     * @return JsonResponse
     */
    public function changeStatus(LeaveChangeStatusRequest $request, LeaveRequest $leave)
    {

        $leave->update($request->validated());

        return $this->successResponse(
            new LeaveResource($leave),
            'Leave request status changed successfully'
        );
    }

    /**
     * delete leave request by employee or admin
     *
     * @return JsonResponse
     */
    public function destroy(LeaveRequest $leave)
    {

        $leave->delete();

        return $this->successResponse(
            null,
            'Leave request deleted successfully'
        );
    }
}
