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
use App\Models\Asset;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

    public function getAsset(Company $company, Asset $asset)
    {
        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $asset);
    }

    public function deleteAsset(Company $company, Asset $asset)
    {
        $asset->delete();

        return $this->response(Response::HTTP_OK, __('messages.asset-deleted'));
    }

    public function updateAsset(Request $request, Company $company, Asset $asset)
    {
        switch ($request->query('type')) {
            case 'stolen':
                return $this->markAssetAsStolen($asset);
            case 'archive':
                return $this->markAssetAsArchived($asset);
            case 'image':
                $image = $request->file('image');
                if(!$image){
                    return $this->error(Response::HTTP_BAD_REQUEST, __('messages.provide-asset-image'));
                }


            default:
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.action-not-allowed'));
        };
    }

    private function markAssetAsStolen(Asset $asset)
    {
        $stolenAsset = $this->assetRepository->markAsStolen($asset->id);

        return $this->response(Response::HTTP_OK, __('messages.asset-marked-as-stolen'), $stolenAsset);
    }

    private function markAssetAsArchived(Asset $asset)
    {
        $archivedAsset = $this->assetRepository->markAsArchived($asset->id);

        return $this->response(Response::HTTP_OK, __('messages.asset-archived'), $archivedAsset);
    }

    private function uploadAssetImage(UploadedFile $image, Asset $asset)
    {
        $extension = $image->getClientOriginalExtension();

        $fileName = sprintf('%s-%s.%s', time(), Str::uuid(), $extension);
    }
}
