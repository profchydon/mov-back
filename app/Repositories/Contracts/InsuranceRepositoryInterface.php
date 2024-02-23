<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\Insurance;

interface InsuranceRepositoryInterface extends  BaseRepositoryInterface
{
    public function getCompanyInsurance(Company $company);

    public function getInsurance(string|Insurance $insurance);

    public function insureAssets(Insurance $insurance, array $assets);
}
