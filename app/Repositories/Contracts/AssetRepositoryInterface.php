<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\CreateDamagedAssetDTO;
use App\Domains\DTO\Asset\CreateRetiredAssetDTO;
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
     * @param Array<UploadedFile>|null $documents
     * @return Asset
     */
    public function markAsStolen(string $assetId, CreateStolenAssetDTO $dto, ?array $documents): Asset;

    public function markAsArchived(string $assetId): Asset;

    public function getCompanyAssets(Company|string $company);

    public function getCompanyStolenAssets(Company|string $company);

    public function getCompanyDamagedAssets(Company|string $company);


    /**
     * @param string $assetId
     * @param CreateDamagedAssetDTO $dto
     * @param Array<UploadedFile>|null $documents
     * @return Asset
     */
    public function markAsDamaged(string $assetId, CreateDamagedAssetDTO $dto, ?array $documents): Asset;

    public function markAsRetired(string $assetId, CreateRetiredAssetDTO $dto): Asset;

}
