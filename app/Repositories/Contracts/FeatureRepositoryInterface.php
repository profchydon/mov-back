<?php

namespace App\Repositories\Contracts;

interface FeatureRepositoryInterface
{
    public function getFeatures();

    public function getAddOnFeatures();
}
