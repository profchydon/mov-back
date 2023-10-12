<?php

namespace App\Repositories\Contracts;

use App\Models\Asset;
use App\Models\Company;
use Illuminate\Http\UploadedFile;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function getCheckouts();

    public function getArchived();

    public function importCompanyAssets(Company $company, UploadedFile $file);

    public function markAsStolen(string $assetId): Asset;

    public function markAsArchived(string $assetId): Asset;
}
