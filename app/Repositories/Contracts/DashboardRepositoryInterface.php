<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface DashboardRepositoryInterface
{
    public function getCompanyDashboardData(string|Company $company);
}
