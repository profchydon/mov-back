<?php

namespace App\Repositories\Contracts;

use App\Models\Asset;
use App\Models\Company;
use Illuminate\Http\UploadedFile;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function importCompanyAssets(Company $company, UploadedFile $file);

    public function markAsStolen(string $assetId): Asset;

    public function markAsArchived(string $assetId): Asset;

    public function getCompanyAssets(Company|string $company);
}
