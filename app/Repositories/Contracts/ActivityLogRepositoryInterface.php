<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface ActivityLogRepositoryInterface
{
    public function getActivityLogs(Company $company);
}
