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
use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\AssetMakeConstant;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
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
        private readonly AssetMakeRepositoryInterface $assetMakeRepository
    ) {
    }

    /**
     * @param CreateAssetRequest $request
     * @return JsonResponse
     */
    public function create(Company $company, CreateAssetRequest $request): JsonResponse
    {
        Log::info('Asset Creation Request Received', $request->all());

        try {

            $createAssetDto = $request->createAssetDTO()
                ->setCompanyId($company->id)
                ->setTenantId($company->tenant_id)
                ->toArray();

            $asset = $this->assetRepository->create($createAssetDto);

            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $asset);

        } catch (\ErrorException $exception) {
            Log::info('Asset Creation Error', $request->all());
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));

        } catch (Exception $exception) {
            Log::info('Asset Creation Error', $request->all());
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));
        }
    }

    /**
     * @return JsonResponse
     */
    public function get(Company $company): JsonResponse
    {

        $assets = $this->assetRepository->getWithRelation(AssetConstant::COMPANY_ID, $company->id, ['type', 'office']);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assets);
    }

    public function getAssetMakes(Company $company)
    {
        $assetMakes = $this->assetMakeRepository->get(AssetMakeConstant::COMPANY_ID, $company->id);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assetMakes);
    }
}
