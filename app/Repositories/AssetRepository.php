<?php

namespace App\Repositories;

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Domains\DTO\Asset\CreateDamagedAssetDTO;
use App\Domains\DTO\Asset\CreateRetiredAssetDTO;
use App\Domains\DTO\Asset\CreateStolenAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\AssetCheckout;
use App\Models\AssetMaintenance;
use App\Models\Company;
use App\Models\DamagedAsset;
use App\Models\RetiredAsset;
use App\Models\StolenAsset;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use App\Repositories\Contracts\AssetMaintenanceRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface, AssetCheckoutRepositoryInterface, AssetMaintenanceRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }

    public function getCompanyAssets(Company|string $company)
    {
        if (!($company instanceof Company)) {
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

    public function markAsStolen(string $assetId, CreateStolenAssetDTO $dto, ?array $documents): Asset
    {
        DB::transaction(function () use ($assetId, $dto, $documents) {
            $stolenAsset = StolenAsset::create($dto->toArray());

            $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::STOLEN->value]);

            if ($documents) {
                collect($documents)->each(function ($document) use ($stolenAsset) {
                    Storage::disk('s3')->putFileAs('', $document, $document->getClientOriginalName());
                    $stolenAsset->documents()->create(['path' => $document->getClientOriginalName()]);
                });
            }
        });

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

    public function getMaintenanceLogs(Company $company)
    {
        $maintenance = $company->asset_maintenance()->orderBy('created_at', 'desc');
        $maintenance = $maintenance->with('asset');
        $maintenance = AssetMaintenance::appendToQueryFromRequestQueryParameters($maintenance);

        return $maintenance->simplePaginate();

    }

    public function markAsDamaged(string $assetId, CreateDamagedAssetDTO $dto, ?array $documents): Asset
    {
        DB::transaction(function () use ($assetId, $dto, $documents) {
            $damagedAsset = DamagedAsset::create($dto->toArray());

            $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::DAMAGED->value]);

            if ($documents) {
                collect($documents)->each(function ($document) use ($damagedAsset) {
                    Storage::disk('s3')->putFileAs('', $document, $document->getClientOriginalName());
                    $damagedAsset->documents()->create(['path' => $document->getClientOriginalName()]);
                });
            }
        });

        return $this->first('id', $assetId);
    }

    public function markAsRetired(string $assetId, CreateRetiredAssetDTO $dto): Asset
    {
        DB::transaction(function () use ($assetId, $dto) {
            RetiredAsset::create($dto->toArray());

            $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::RETIRED->value]);
        });

        return $this->first('id', $assetId);
    }

    public function getCompanyStolenAssets(Company|string $company)
    {
       if(! ($company instanceof  Company)){
           $company = Company::findOrFail($company);
       }

       return $company->stolenAssets()->with(['asset', 'documents'])->simplePaginate();
    }

    public function getCompanyDamagedAssets(Company|string $company)
    {
        if(! ($company instanceof  Company)){
            $company = Company::findOrFail($company);
        }

        return $company->damagedAssets()->with(['asset', 'documents'])->simplePaginate();
    }
}
