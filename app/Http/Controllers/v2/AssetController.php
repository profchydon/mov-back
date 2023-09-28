<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Asset\CreateAssetRequest;


class AssetController extends Controller
{

    /**
     * AssetController constructor.
     * @param AssetRepositoryInterface $assetRepository
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private readonly AssetRepositoryInterface $assetRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
    ) {}

    /**
     * @param CreateAssetRequest $request
     * @return JsonResponse
     * @throws \Throwable|AuctionNotFoundException
     * @throws \Throwable|AuctioneeAlreadyInvitedException
     * @throws \Throwable|AuctionDoesNotBelongToException
     */
    public function create(CreateAssetRequest $request): JsonResponse
    {
        Log::info('Asset Creation Request Received', $request->all());

        try {


            try {


            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $dbData);

        } catch (\ErrorException $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }
}
