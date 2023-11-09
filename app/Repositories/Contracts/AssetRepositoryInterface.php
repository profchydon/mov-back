<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\CreateStolenAssetDTO;
use App\Models\Asset;
use App\Models\Company;
use Illuminate\Http\UploadedFile;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function importCompanyAssets(Company $company, UploadedFile $file);

    /**
     * @param string $assetId
     * @param CreateStolenAssetDTO $dto
     * @param Array<UploadedFile> $documents
     * @return Asset
     */
    public function markAsStolen(string $assetId, CreateStolenAssetDTO $dto, ?array $documents): Asset;

    public function markAsArchived(string $assetId): Asset;

    public function getCompanyAssets(Company|string $company);
}
