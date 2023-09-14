<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var Company $company
         */
        $company = $this->resource;

        return [
            'id' => $company->id,
            'name' => $company->name,
            'size' => $company->size,
            'address' => $company->address,
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
        ];
    }
}
