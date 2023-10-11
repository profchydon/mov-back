<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use Illuminate\Http\UploadedFile;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function importCompanyAssets(Company $company, UploadedFile $file);
}
