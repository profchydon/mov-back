<?php

namespace App\Http\Controllers\V2;

use App\Domains\Auth\PermissionTypes;
use App\Domains\Auth\RoleTypes;
use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\AssetMakeConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Domains\DTO\Asset\UpdateAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Models\Asset;
use App\Models\Company;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Rules\HumanNameRule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        private readonly AssetMakeRepositoryInterface $assetMakeRepository,
        private readonly FileRepositoryInterface $fileRepository
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
                ->setTenantId($company->tenant_id);

            $user = $request->user();
            if ($user->hasAnyRole(RoleTypes::ADMINISTRATOR->value, RoleTypes::ASSET_MANAGER->value)) {
                $createAssetDto->setStatus(AssetStatusEnum::AVAILABLE->value);
            }

            $asset = $this->assetRepository->create($createAssetDto->toArray());

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
        $assets = $this->assetRepository->getCompanyAssets($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assets);
    }

    public function getAssetMakes(Company $company)
    {
        $assetMakes = $this->assetMakeRepository->get(AssetMakeConstant::COMPANY_ID, $company->id);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assetMakes);
    }

    public function createBulk(Company $company, Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        $import = $this->assetRepository->importCompanyAssets($company, $request->file('file'));

        return $this->response(Response::HTTP_ACCEPTED, __('messages.processing'), $import);
    }

    public function getBulkDownloadTemplate(Company $company, Request $request)
    {
        $path = url(asset('assets/templates/assets_upload_template.xlsx'));

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $path);
    }

    public function getAsset(Company $company, string $assetId)
    {
        $asset = $this->assetRepository->firstWithRelation('id', $assetId, ['image']);

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
                if (!$image) {
                    return $this->error(Response::HTTP_BAD_REQUEST, __('messages.provide-asset-image'));
                }

                return $this->uploadAssetImage($request->image, $asset);
            case 'details':
                return $this->updateAssetDetails($request, $asset);

            default:
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.action-not-allowed'));
        }
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

        if ($asset->image != null) {
            Storage::disk('s3')->delete($asset->image->path);
            $this->fileRepository->deleteById($asset->image->id);
        }

        $path = $image->storeAs('asset-images', $fileName, 's3');
        $path = Storage::disk('s3')->url($path);

        $asset->image()->create(['path' => $path]);

        return $this->response(Response::HTTP_OK, __('messages.asset-image-updated'));
    }

    private function updateAssetDetails(Request $request, Asset $asset)
    {
        $request->validate([
            'make' => ['nullable', new HumanNameRule()],
            'model' => ['nullable', new HumanNameRule()],
            'type_id' => ['nullable', Rule::exists('asset_types', 'id')],
            'serial_number' => 'nullable|string',
            'purchase_price' => ['nullable', 'decimal:2,4'],
            'purchase_date' => 'nullable|date',
            'office_id' => ['nullable', Rule::exists('offices', 'id')],
            'office_area_id' => ['nullable', Rule::exists('office_areas', 'id')],
            'currency' => ['nullable', Rule::exists('currencies', 'code')],
            'acquisition_type' => ['nullable', 'string'],
            'custom_tags' => ['nullable', 'array'],
            'vendor_id' => ['nullable', Rule::exists('vendors', 'id')],
            'condition' => ['nullable', 'string'],
            'maintenance_cycle' => ['nullable', 'string'],
            'next_maintenance_date' => ['nullable', 'date'],
        ]);

        if ($request->input('status') != null) {
            $user = $request->user();
            if (!$user->hasAnyRole(RoleTypes::ADMINISTRATOR->value, RoleTypes::ASSET_MANAGER->value)) {
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.only-admins-can-approve'));
            }

            if($asset->status != AssetStatusEnum::PENDING_APPROVAL->value){
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.wrong-status-update'));
            }
        }


        $image = $request->file('image');
        if ($image) {
            $this->uploadAssetImage($request->image, $asset);
        }

        $dto = new UpdateAssetDTO();
        $dto->setMake($request->input('make'))
            ->setModel($request->input('model'))
            ->setTypeId($request->input('type_id'))
            ->setSerialNumber($request->input('serial_number'))
            ->setPurchasePrice($request->input('purchase_price'))
            ->setPurchaseDate($request->input('purchase_date'))
            ->setOfficeId($request->input('office_id'))
            ->setOfficeAreaId($request->input('office_area_id'))
            ->setCurrency($request->input('currency'))
            ->setVendorId($request->input('vendor_id'))
            ->setAcquisitionType($request->input('acquisition_type'))
            ->setCondition($request->input('condition'))
            ->setMaintenanceCycle($request->input('maintenance_cycle'))
            ->setNextMaintenanceDate($request->input('next_maintenance_date'))
            ->setStatus($request->input('status'));

        $this->assetRepository->updateById($asset->id, $dto->toSynthensizedArray());

        $asset->refresh();
        return $this->response(Response::HTTP_OK, __('messages.asset-updated'), $asset);
    }
}
