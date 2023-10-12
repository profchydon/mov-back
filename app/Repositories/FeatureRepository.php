<?php

namespace App\Repositories;

use App\Domains\Constant\FeatureConstant;
use App\Models\Feature;
use App\Repositories\Contracts\FeatureRepositoryInterface;

class FeatureRepository implements FeatureRepositoryInterface
{
    public function getFeatures()
    {
        return Feature::with('prices')->simplePaginate();
    }

    public function getAddOnFeatures()
    {
        return Feature::where(FeatureConstant::AVAILABLE_AS_ADDON, true)->with('prices')->simplePaginate();
    }
}
