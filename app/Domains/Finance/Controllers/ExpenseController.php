<?php

namespace App\Domains\Finance\Controllers;

use App\Domains\Finance\Models\Expense;
use App\Domains\Finance\Requests\StoreExpenseRequest;
use App\Domains\Finance\Resources\ExpenseResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\TenantGuard;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    //
    use TenantGuard;

    /**
     * list invoices
     *
     * @return JsonResponse
     */
    public function index()
    {
        authorizePermission('view expenses', $this->getGuard());
        $expenses = Expense::with('employee')->paginate(20);

        return ApiResponse::success(
            ExpenseResource::collection($expenses),
            'Expenses retrieved successfully', 200, $expenses->nextPageUrl()
        );
    }

    /**
     *  update invoice from employee
     *
     * @return JsonResponse
     */
    public function store(StoreExpenseRequest $request)
    {
        authorizePermission('store expenses', $this->getGuard());
        $request_data = $request->validated();
        $server_made_data = [
            'added_by' => auth()->guard('tenant-api')->id(),

        ];

        $expense_data = array_merge($request_data, $server_made_data);

        $expense = Expense::create($expense_data);

        return ApiResponse::success(
            new ExpenseResource($expense),
            'Expense created successfully',
            201
        );

    }

    /**
     * update invoice from employee or admin
     *
     * @return JsonResponse
     */
    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        authorizePermission('update expenses', $this->getGuard());
        $expense->update($request->validated());

        return ApiResponse::success(
            new ExpenseResource($expense),
            'Expense updated successfully'
        );
    }

    /**
     * delete leave request by employee or admin
     *
     * @return JsonResponse
     */
    public function destroy(Expense $expense)
    {
        authorizePermission('destroy expenses', $this->getGuard());
        $expense->delete();

        return ApiResponse::success(
            null,
            'Expense deleted successfully'
        );
    }
}
