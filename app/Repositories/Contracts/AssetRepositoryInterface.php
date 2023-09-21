<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Asset;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function create($data): Asset;

}
