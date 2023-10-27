<?php

namespace App\Http\Resources\Company;

use App\Domains\Constant\CompanyConstant;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Company $user */
        $company = $this->resource;

        return [
            CompanyConstant::ID => $company->id,
            CompanyConstant::NAME => $company->name,
            CompanyConstant::EMAIL => $company->email,
            CompanyConstant::SIZE => $company->size,
            CompanyConstant::PHONE => $company->phone,
            CompanyConstant::INDUSTRY => $company->industry,
            CompanyConstant::ADDRESS => $company->address,
            CompanyConstant::COUNTRY => $company->country,
            CompanyConstant::STATE => $company->state,
            CompanyConstant::STATUS => $company->status,
        ];
    }
}
