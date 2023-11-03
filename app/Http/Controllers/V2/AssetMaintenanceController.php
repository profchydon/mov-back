<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\AssetMaintenanceRepository;

class AssetMaintenanceController extends Controller
{
    public function __construct(private readonly AssetMaintenanceRepository $maintenanceRepository)
    {
    }

    public function store(){

    }
}
