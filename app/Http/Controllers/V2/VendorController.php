<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\Company;
use App\Repositories\Contracts\VendorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorController extends Controller
{
    public function __construct(private readonly VendorRepositoryInterface $vendorRepository)
    {
    }

    public function create(CreateVendorRequest $request, Company $company)
    {
        $dto = $request->getDTO();

        $dto->setCompanyId($company->id)
            ->setTenantId($company->tenant->id);

        $vendor = $this->vendorRepository->create($dto->toSynthensizedArray());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $vendor);
    }
}
