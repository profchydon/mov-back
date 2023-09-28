<?php

namespace App\Repositories;

use App\Domain\DTO\Asset\CreateAssetTypeDTO;
use App\Models\AssetType;
use App\Repositories\Contracts\AssetTypeRepositoryInterface;

class AssetTypeRepository extends BaseRepository implements AssetTypeRepositoryInterface
{
    public function model(): string
    {
        return AssetType::class;
    }

}
