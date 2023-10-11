<?php

namespace App\Repositories;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\AssetCheckout;
use App\Models\Company;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface, AssetCheckoutRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }


    public function importCompanyAssets(Company $company, UploadedFile $file)
    {
        $import = new AssetImport($company);

        return Excel::queueImport($import, $file);
    }

    public function checkoutAsset(AssetCheckoutDTO $checkoutDTO)
    {
        return AssetCheckout::create($checkoutDTO->toArray());
    }

    public function getAssetCheckouts(Asset|string $asset)
    {
        // TODO: Implement getAssetCheckouts() method.
    }

    public function getAssetCheckout(AssetCheckout|string $checkout)
    {
        // TODO: Implement getAssetCheckout() method.
    }
}
