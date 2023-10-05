<?php

namespace App\Repositories;

use App\Models\Feature;
use App\Repositories\Contracts\FeatureRepositoryInterface;

class FeatureRepository implements FeatureRepositoryInterface
{
    public function getFeatures()
    {
        return Feature::with('prices')->simplePaginate();
    }
}
