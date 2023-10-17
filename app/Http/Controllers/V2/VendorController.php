<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\VendorConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\Company;
use App\Models\Vendor;
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

    public function index(Company $company)
    {
        $vendors = $this->vendorRepository->get(VendorConstant::COMPANY_ID, $company->id);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $vendors);
    }

    public function show(Company $company, Vendor $vendor)
    {
        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $vendor);
    }

    public function update(CreateVendorRequest $request, Company $company, Vendor $vendor)
    {
        $dto = $request->getDTO();

        $this->vendorRepository->update(VendorConstant::ID, $vendor->id, $dto->toSynthensizedArray());
        $vendor->refresh();

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $vendor);
    }

    public function destroy(Company $company, Vendor $vendor)
    {
        $this->vendorRepository->deleteById($vendor->id);

        return $this->response(Response::HTTP_OK, __('messages.record-deleted'));
    }
}
