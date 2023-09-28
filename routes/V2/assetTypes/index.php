<?php

use App\Http\Controllers\V2\AssetTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/asset-types', [AssetTypeController::class, 'fetchAssetTypes'])->name('asset.types.fetch');