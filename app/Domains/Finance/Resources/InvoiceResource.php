<?php

namespace App\Domains\Finance\Resources;

use App\Domains\Employee\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
             'employee' => new EmployeeResource($this->whenLoaded('employee')),

        ];
    }
}
