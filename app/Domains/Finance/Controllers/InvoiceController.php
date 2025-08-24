<?php

namespace App\Domains\Finance\Controllers;

use App\Domains\Finance\Models\Invoice;
use App\Domains\Finance\Requests\InvoiceChangeStatusRequest;
use App\Domains\Finance\Requests\StoreInvoiceRequest;
use App\Domains\Finance\Resources\InvoiceResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
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

        $invoices = Invoice::with('employee')->paginate(10);

        return $this->successResponse(
            InvoiceResource::collection($invoices),
            'Invoices retrieved successfully'
            , 200, $invoices->nextPageUrl()
        );
    }

    /**
     *  update invoice from employee
     *
     * @return JsonResponse
     */
    public function store(StoreInvoiceRequest $request)
    {

        $request_data = $request->validated();
        $server_made_data = [
            'employee_id' => auth()->guard('tenant-api')->id(),

        ];

        $invoice_data = array_merge($request_data, $server_made_data);

        $invoice = Invoice::create($invoice_data);

        return $this->successResponse(
            new InvoiceResource($invoice),
            'Invoice created successfully',
            201
        );

    }

    /**
     * update invoice from employee or admin
     *
     * @return JsonResponse
     */
    public function update(StoreInvoiceRequest $request, Invoice $invoice)
    {

        $invoice->update($request->validated());

        return $this->successResponse(
            new InvoiceResource($invoice),
            'Invoice updated successfully'
        );
    }

    /**
     * change the status of invoice from employee or admin
     *
     * @return JsonResponse
     */
    public function changeStatus(InvoiceChangeStatusRequest $request, Invoice $invoice)
    {

        $invoice->update($request->validated());

        return $this->successResponse(
            new InvoiceResource($invoice),
            'Invoice status changed successfully'
        );
    }

    /**
     * delete leave request by employee or admin
     *
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice)
    {

        $invoice->delete();

        return $this->successResponse(
            null,
            'Invoice deleted successfully'
        );
    }
}
