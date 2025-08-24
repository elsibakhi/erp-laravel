<?php

namespace App\Domains\Finance\Controllers;

use App\Domains\Finance\Models\Expense;
use App\Domains\Finance\Models\Invoice;
use App\Domains\Finance\Requests\StoreExpenseRequest;
use App\Domains\Finance\Resources\ExpenseResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    //
    use ApiResponse;

    /**
     * list invoices
     *
     * @return JsonResponse
     */
    public function index()
    {

        $expenses = Expense::with('employee')->get();

        return $this->successResponse(
            ExpenseResource::collection($expenses),
            'Expenses retrieved successfully'
        );
    }

    /**
     *  update invoice from employee
     *
     * @return JsonResponse
     */
    public function store(StoreExpenseRequest $request)
    {

        $request_data = $request->validated();
        $server_made_data = [
            'added_by' => auth()->guard('tenant-api')->id(),

        ];

        $expense_data = array_merge($request_data, $server_made_data);

        $expense = Expense::create($expense_data);

        return $this->successResponse(
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

        $expense->update($request->validated());

        return $this->successResponse(
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

        $expense->delete();

        return $this->successResponse(
            null,
            'Expense deleted successfully'
        );
    }
}
