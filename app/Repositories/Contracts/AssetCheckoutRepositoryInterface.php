<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Models\Asset;
use App\Models\AssetCheckout;

interface AssetCheckoutRepositoryInterface
{
    public function checkoutAsset(AssetCheckoutDTO $checkoutDTO);

    public function updateAssetCheckout(AssetCheckout|string $checkout, AssetCheckoutDTO $checkoutDTO);

    public function getCheckouts();

    public function getAssetCheckouts(Asset|string $asset);

    public function getAssetCheckout(AssetCheckout|string $checkout);
}
