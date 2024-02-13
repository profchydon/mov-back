<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Models\Company;
use App\Models\Insurance;
use App\Repositories\Contracts\InsuranceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InsuranceController extends Controller
{
    public function __construct(private InsuranceRepositoryInterface $insuranceRepository)
    {
    }

    public function store(Company $company, CreateInsuranceRequest $request)
    {
        $dto = $request->toDTO();
        $dto->setCompanyId($company->id)
            ->setTenantId($company->tenant_id);

        $insurance = $this->insuranceRepository->create($dto->toArray());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $insurance);
    }

    public function index(Company $company)
    {
        $insurances = $this->insuranceRepository->getCompanyInsurance($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $insurances);
    }

    public function show(Company $company, Insurance $insurance)
    {
        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $insurance);
    }

    public function update(Company $company, Insurance $insurance, UpdateInsuranceRequest $request)
    {
        $insurance = $this->insuranceRepository->updateById($insurance->id, $request->toDTO()->toSynthensizedArray());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $insurance);

    }

    public function destroy(Company $company, Insurance $insurance)
    {
        $this->insuranceRepository->deleteById($insurance->id);

        return $this->noContent();
    }
}
