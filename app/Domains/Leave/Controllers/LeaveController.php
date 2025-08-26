<?php

namespace App\Domains\Leave\Controllers;

use App\Domains\Leave\Models\LeaveRequest;
use App\Domains\Leave\Requests\LeaveChangeStatusRequest;
use App\Domains\Leave\Requests\StoreLeaveRequest;
use App\Domains\Leave\Resources\LeaveResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\TenantGuard;
use Illuminate\Http\JsonResponse;

class LeaveController extends Controller
{
    //
    use TenantGuard;

    /**
     * list leave requests for admin
     *
     * @return JsonResponse
     */
    public function adminLeaveRequestsList()
    {
        authorizePermission('view all leave requests', $this->getGuard());
        $leave_requests = LeaveRequest::with('employee')->paginate(10);

        return ApiResponse::success(
            LeaveResource::collection($leave_requests),
            'Leave requests retrieved successfully',
            200,
            $leave_requests->nextPageUrl()
        );
    }

    /**
     * list leave requests for a specific authenticated employee
     *
     * @return JsonResponse
     */
    public function employeeLeaveRequestsList()
    {
        authorizePermission('view employee leave requests', $this->getGuard());
        $employee = auth()->guard('tenant-api')->user();
        $leave_requests = LeaveRequest::with('employee')->where('employee_id', $employee->id)->paginate(10);

        return ApiResponse::success(
            LeaveResource::collection($leave_requests),
            'Leave requests retrieved successfully', 200, $leave_requests->nextPageUrl()
        );
    }

    /**
     * store leave request from employee
     *
     * @return JsonResponse
     */
    public function store(StoreLeaveRequest $request)
    {

        authorizePermission('store leave requests', $this->getGuard());

        $request_data = $request->validated();
        $server_made_data = [
            'employee_id' => auth()->guard('tenant-api')->id(),

        ];

        $leave_data = array_merge($request_data, $server_made_data);

        $leave_request = LeaveRequest::create($leave_data);

        return ApiResponse::success(
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
        authorizePermission('update leave requests', $this->getGuard());
        $leave->update($request->validated());

        return ApiResponse::success(
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
        authorizePermission('change leave requests status', $this->getGuard());
        $leave->update($request->validated());

        return ApiResponse::success(
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
        authorizePermission('destroy leave requests', $this->getGuard());
        $leave->delete();

        return ApiResponse::success(
            null,
            'Leave request deleted successfully'
        );
    }
}
