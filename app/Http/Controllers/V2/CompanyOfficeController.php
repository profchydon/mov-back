<?php

namespace App\Http\Controllers\V2;

use App\Domains\Enum\Office\OfficeStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyOfficeRequest;
use App\Http\Requests\Company\UpdateCompanyOfficeRequest;
use App\Models\Company;
use App\Models\Office;
use App\Models\OfficeArea;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CompanyOfficeController extends Controller
{
    public function __construct(private readonly CompanyOfficeRepositoryInterface $companyOfficeRepository)
    {
    }

    public function index(Company $company, Request $request)
    {
        $offices = $this->companyOfficeRepository->getCompanyOffices($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $offices);
    }

    public function store(Company $company, CreateCompanyOfficeRequest $request)
    {
        $office = $this->companyOfficeRepository->createCompanyOffice($request->companyOfficeDTO());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $office);
    }

    public function show(Company $company, Office $office, Request $request)
    {
        $office = $this->companyOfficeRepository->getCompanyOffice($office);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $office);
    }

    public function update(Company $company, Office $office, UpdateCompanyOfficeRequest $request)
    {
        $office = $this->companyOfficeRepository->updateCompanyOffice($office, $request->companyOfficeDTO());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $office);
    }

    public function destroy(Company $company, Office $office)
    {
        $this->companyOfficeRepository->deleteCompanyOffice($office);

        return $this->noContent();
    }

    public function storeOfficeArea(Office $office, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|regex:/\b[a-zA-Z]{3,}(?:\s[a-zA-Z]+)*\b/',
        ]);

        $officeArea = $this->companyOfficeRepository->createOfficeArea($office, $request->input('name'));

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $officeArea);
    }

    public function updateOfficeArea(Office $office, OfficeArea $officeArea, Request $request)
    {
        $this->validate($request, [
            'name' => 'sometimes|min:3|regex:/\b[a-zA-Z]{3,}(?:\s[a-zA-Z]+)*\b/',
            'status' => ['sometimes', Rule::in(OfficeStatusEnum::values())],
        ]);

        $officeArea = $this->companyOfficeRepository->updateOfficeArea($officeArea, $request->only('name', 'status'));

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $officeArea);
    }

    public function destroyOfficeArea(Office $office, OfficeArea $officeArea, Request $request)
    {
        $this->companyOfficeRepository->deleteOfficeArea($officeArea);

        return $this->noContent();
    }
}
