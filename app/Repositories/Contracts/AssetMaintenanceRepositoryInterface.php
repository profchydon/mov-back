<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\AssetMaintenanceDTO;

interface AssetMaintenanceRepositoryInterface
{
    public function createMaintenanceLog(AssetMaintenanceDTO $maintenanceDTO);
}
