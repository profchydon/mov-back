<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\AssetTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\CreateAssetTypeRequest;
use App\Repositories\Contracts\AssetTypeRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AssetTypeController extends Controller
{
    /**
     * AssetTypeController constructor.
     * @param AssetTypeRepositoryInterface $assetRepository
     */
    public function __construct(
        private readonly AssetTypeRepositoryInterface $assetTypeRepository,
    ) {
    }

    /**
     * @param CreateAssetTypeRequest $request
     * @return JsonResponse
     * @throws \Throwable|AuctionNotFoundException
     */
    public function create(CreateAssetTypeRequest $request)
    {
        Log::info('Asset Type Creation Request Received', $request->all());

        try {
            $name = $request->createAssetTypeDTO()->getName();

            $assetType = $this->assetTypeRepository->firstLike(AssetTypeConstant::NAME, $name);

            if (!$assetType) {
                $assetTypeDto = $request->createAssetTypeDTO()->toArray();
                $assetType = $this->assetTypeRepository->create($assetTypeDto);
            }

            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $assetType);
        } catch (\ErrorException $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }

    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $assetTypes = $this->assetTypeRepository->all();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assetTypes);
    }
}
