<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AssetTypeRepositoryInterface;
use Illuminate\Http\Response;

class AssetTypeController extends Controller
{
    public function __construct(private readonly AssetTypeRepositoryInterface $assetTypeRepository)
    {
    }

    public function fetchAssetTypes()
    {
        $assetTypes = $this->assetTypeRepository->all();

        return $this->response(Response::HTTP_OK, null, $assetTypes);
    }
}
