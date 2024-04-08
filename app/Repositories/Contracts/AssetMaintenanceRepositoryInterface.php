<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Models\Asset;
use App\Models\Company;

interface AssetMaintenanceRepositoryInterface
{
    public function createMaintenanceLog(AssetMaintenanceDTO $maintenanceDTO);

    public function getMaintenanceLogs(Company $company);

    public function getMaintenanceMaps(Company $company, $timeframe = null);

    public function getAssetMaintenance(Asset|string $asset);
}
