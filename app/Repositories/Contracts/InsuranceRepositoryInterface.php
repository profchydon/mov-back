<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface InsuranceRepositoryInterface extends  BaseRepositoryInterface
{
    public function getCompanyInsurance(Company $company);
}
