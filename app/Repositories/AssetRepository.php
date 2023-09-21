<?php

namespace App\Repositories;

use App\Domain\DTO\Asset\CreateAssetDTO;
use App\Models\Asset;
use App\Repositories\Contracts\AssetRepositoryInterface;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }


    public function create(CreateAssetDTO $companyDTO)
    {

    }

    public function getCheckouts()
    {
        //TODO: write the logic to return all asset checkouts
    }

    public function getArchived()
    {
        //TODO: write the logic to return all archived assets
    }
}
