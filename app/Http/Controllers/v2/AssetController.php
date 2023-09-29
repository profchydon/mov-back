<?php

namespace App\Http\Controllers\V2;

use Exception;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Domains\Constant\CompanyConstant;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;


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
    ) {
    }

    /**
     * @param CreateAssetRequest $request
     * @return JsonResponse
     */
    public function create(CreateAssetRequest $request): JsonResponse
    {
        Log::info('Asset Creation Request Received', $request->all());

        try {

            $company = $this->companyRepository->first(CompanyConstant::ID, $request->company_id);

            $createAssetDto = $request->createAssetDTO()->setTenantId($company->tenant_id)->toArray();

            $asset = $this->assetRepository->create($createAssetDto);

            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $asset);

        } catch (\ErrorException $exception) {
            Log::info('Asset Creation Error', $request->all());
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));

        } catch (Exception $exception) {
            Log::info('Asset Creation Error', $request->all());
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }
}
