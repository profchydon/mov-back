<?php

namespace App\Repositories;

use App\Models\AssetMake;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;

class AssetMakeRepository extends BaseRepository implements AssetMakeRepositoryInterface
{
    public function model(): string
    {
        return AssetMake::class;
    }
}
