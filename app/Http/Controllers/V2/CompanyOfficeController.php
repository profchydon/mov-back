<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyOfficeRequest;
use App\Models\Company;
use App\Models\Office;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function storeOfficeArea(Office $office, \Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|regex:/\b[a-zA-Z]{3,}(?:\s[a-zA-Z]+)*\b/',
        ]);

        $officeArea = $this->companyOfficeRepository->createOfficeArea($office, $request->input('name'));

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $officeArea);
    }

    public function show(Company $company, Office $office, Request $request)
    {
        $office = $this->companyOfficeRepository->getCompanyOffice($office);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $office);
    }
}
