<?php

namespace App\Repositories;

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\AssetCheckout;
use App\Models\AssetMaintenance;
use App\Models\Company;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use App\Repositories\Contracts\AssetMaintenanceRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface, AssetCheckoutRepositoryInterface, AssetMaintenanceRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }

    public function getCompanyAssets(Company|string $company)
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        $assets = $company->assets();
        $assets = $assets->with(['type', 'office', 'assignee'])->orderBy('assets.created_at', 'desc');
        $assets = Asset::appendToQueryFromRequestQueryParameters($assets);

        return $assets->paginate();
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

    public function updateAssetCheckout(AssetCheckout|string $checkout, AssetCheckoutDTO $checkoutDTO)
    {
        if (!($checkout instanceof AssetCheckout)) {
            $checkout = AssetCheckout::findOrFail($checkout);
        }

        $checkout->update($checkoutDTO->toSynthensizedArray());

        return $checkout->fresh();
    }

    public function getAssetCheckouts(Asset|string $asset)
    {
    }

    public function getCheckouts()
    {
        $checkout = AssetCheckout::with('asset')->orderBy('group_id');

        return $checkout->paginate()->groupBy('group_id');
    }

    public function getAssetCheckout(AssetCheckout|string $checkout)
    {
        if (!($checkout instanceof AssetCheckout)) {
            $checkout = AssetCheckout::findOrFail($checkout);
        }

        return $checkout->load('asset', 'receiver');
    }

    public function markAsStolen(string $assetId): Asset
    {
        $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::STOLEN->value]);

        return $this->first('id', $assetId);
    }

    public function markAsArchived(string $assetId): Asset
    {
        $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::ARCHIVED->value]);

        return $this->first('id', $assetId);
    }

    public function createMaintenanceLog(AssetMaintenanceDTO $maintenanceDTO)
    {
        return AssetMaintenance::create($maintenanceDTO->toArray());
    }
}
