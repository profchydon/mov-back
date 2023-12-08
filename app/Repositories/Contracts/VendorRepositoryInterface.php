<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface VendorRepositoryInterface extends BaseRepositoryInterface
{
    public function getVendors(Company|string $company, $relation = []);
}
