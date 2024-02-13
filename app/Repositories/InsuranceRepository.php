<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Insurance;
use App\Repositories\Contracts\InsuranceRepositoryInterface;

class InsuranceRepository extends BaseRepository implements InsuranceRepositoryInterface
{
    public function model()
    {
        return Insurance::class;
    }

    public function getCompanyInsurance(Company $company)
    {
        $insurance = $company->insurances();
        $insurance = Insurance::appendToQueryFromRequestQueryParameters($insurance);

        return $insurance->paginate();
    }
}
