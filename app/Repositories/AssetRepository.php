<?php

namespace App\Repositories;

use App\Domains\Constant\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\Company;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface
{
    public function model(): string
    {
        return Asset::class;
    }

    public function getCheckouts()
    {
        //TODO: write the logic to return all asset checkouts
    }

    public function getArchived()
    {
        //TODO: write the logic to return all archived assets
    }

    public function importCompanyAssets(Company $company, UploadedFile $file)
    {
        $import = new AssetImport($company);

//        Excel::import($import, $file);
        return Excel::queueImport($import, $file);
    }

    public function markAsStolen(string $assetId)
    {
        return $this->update('id', $assetId, [AssetConstant::STATUS => AssetStatusEnum::STOLEN->value]);
    }
}
