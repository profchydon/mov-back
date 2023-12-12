<?php

namespace App\Repositories;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Domains\DTO\Asset\CreateDamagedAssetDTO;
use App\Domains\DTO\Asset\CreateRetiredAssetDTO;
use App\Domains\DTO\Asset\CreateStolenAssetDTO;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Http\Resources\Asset\AssetCheckoutCollection;
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

class AssetRepository extends BaseRepository implements AssetRepositoryInterface, AssetCheckoutRepositoryInterface, AssetMaintenanceRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }

    public function getCompanyAssets(Company|string $company, string|null $status)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $statusArray = $status === null ? AssetStatusEnum::values() : [$status];

        $assets = $company->assets()->status($statusArray)->with(['type', 'office', 'assignee'])->orderBy('assets.created_at', 'desc');
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
        if (!($asset instanceof Asset)) {
            $asset = Asset::findOrFail($asset);
        }

        $checkouts = $asset->checkouts();
        $checkouts = AssetCheckout::appendToQueryFromRequestQueryParameters($checkouts);

        return $checkouts->paginate();
    }

    public function getAssetMaintenance(Asset|string $asset)
    {
        if (!($asset instanceof Asset)) {
            $asset = Asset::findOrFail($asset);
        }

        $maintenance = $asset->maintenances();
        $maintenance = AssetCheckout::appendToQueryFromRequestQueryParameters($maintenance);

        return $maintenance->paginate();
    }

    public function getGroupAssetCheckout(AssetCheckout|string $groupId, string|null $status)
    {
        $statusArray = $status === null ? AssetCheckoutStatusEnum::values() : [$status];

        $checkout = AssetCheckout::status($statusArray)->with('asset', 'receiver', 'checkedOutBy')->where(AssetCheckoutConstant::GROUP_ID, $groupId);

        $checkout = $checkout->paginate();

        return AssetCheckoutCollection::make($checkout);
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

    public function markAsRetired(CreateRetiredAssetDTO $dto): Asset
    {
        DB::transaction(function () use ($dto) {
            RetiredAsset::create($dto->toArray());

            $this->update('id', $dto->getAssetId(), [AssetConstant::STATUS => AssetStatusEnum::RETIRED->value]);
        });

        return $this->first('id', $dto->getAssetId());
    }

    public function getCompanyStolenAssets(Company|string $company)
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        return $company->stolenAssets()->with(['asset', 'documents'])->simplePaginate();
    }

    public function getCompanyDamagedAssets(Company|string $company)
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        return $company->damagedAssets()->with(['asset', 'documents'])->simplePaginate();
    }

    public function returnAssetsInGroup(AssetCheckout|string $groupId, array $assets, array $data)
    {
        $checkoutGroup = AssetCheckout::where(AssetCheckoutConstant::GROUP_ID, $groupId)->whereIn(AssetCheckoutConstant::ASSET_ID, $assets)->get();

        if (!$checkoutGroup) {
            return false;
        }

        try {
            DB::transaction(function () use ($checkoutGroup, $data) {
                $checkoutGroup->each(function (AssetCheckout $assetCheckout) use ($data) {
                    $assetCheckout->update([
                        AssetCheckoutConstant::STATUS => AssetCheckoutStatusEnum::RETURNED,
                        AssetCheckoutConstant::DATE_RETURNED => $data[AssetCheckoutConstant::DATE_RETURNED],
                        AssetCheckoutConstant::RETURN_NOTE => $data[AssetCheckoutConstant::RETURN_NOTE],
                        AssetCheckoutConstant::RETURN_BY => $data[AssetCheckoutConstant::RETURN_BY],
                    ]);

                    $this->update('id', $assetCheckout->asset_id, [AssetConstant::STATUS => AssetStatusEnum::AVAILABLE->value]);
                });
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
