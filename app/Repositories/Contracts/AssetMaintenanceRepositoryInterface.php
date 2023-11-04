<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Models\Company;

interface AssetMaintenanceRepositoryInterface
{
    public function createMaintenanceLog(AssetMaintenanceDTO $maintenanceDTO);

    public function getMaintenanceLogs(Company $company);
}
