<?php

namespace App\Repositories;

use App\Models\Asset;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }

    public function checkouts()
    {
        //TODO: write the logic to return all asset checkouts
    }

    public function archived()
    {
        //TODO: write the logic to return all archived assets
    }
}