<?php

namespace App\Http\Controllers\V2;

use App\Common\SubscriptionValidator;
use App\Domains\Auth\PermissionTypes;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\Asset\AssetMakeConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Domains\DTO\Asset\UpdateAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\CreateAssetFromArrayRequest;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\CreateDamagedAssetRequest;
use App\Http\Requests\Asset\CreateRetiredAssetRequest;
use App\Http\Requests\Asset\CreateStolenAsset;
use App\Http\Requests\Asset\ReAssignAssetRequest;
use App\Http\Requests\Asset\ReAssignMultipleAssetRequest;
use App\Http\Requests\Asset\UpdateMultipleAssetsRequest;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Taggable;
use App\Models\User;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Rules\HumanNameRule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    /**
     * AssetController constructor.
     * @param AssetRepositoryInterface $assetRepository
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private readonly AssetRepositoryInterface     $assetRepository,
        private readonly CompanyRepositoryInterface   $companyRepository,
        private readonly AssetMakeRepositoryInterface $assetMakeRepository,
        private readonly FileRepositoryInterface      $fileRepository,
        private readonly TagRepositoryInterface      $tagRepository,
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

            // Check available assets
            $subscriptionValidator = new SubscriptionValidator($company);
            if (!$subscriptionValidator->hasAvailableAssets()) {
                return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.no-available-assets'));
            }

            $createAssetDto = $request->createAssetDTO()
                ->setCompanyId($company->id)
                ->setTenantId($company->tenant_id);

            if ($request->assignee) {
                $createAssetDto->setAssignedDate(now());
            }

            $user = $request->user();

            if ($user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value, PermissionTypes::ASSET_CREATE_ACCESS->value])) {
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

    public function createBulk(Company $company, CreateAssetFromArrayRequest $request)
    {
        $user = $request->user();

        $subscriptionValidator = new SubscriptionValidator($company);
        $assetSpaceLeft = $subscriptionValidator->getAssetSpaceLeft();

        // Check available assets
        if (!$subscriptionValidator->hasAvailableAssets()) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.no-available-assets'));
        }

        if (count($request->assets) > $assetSpaceLeft) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, sprintf(
                "You have only %d asset space(s) left. Upgrade your plan to accommodate additional assets, or make sure you upload no more than %d asset(s).",
                $assetSpaceLeft,
                $assetSpaceLeft
            ));
        }

        $assets = collect($request->assets)->transform(function ($asset) use ($company, $user) {
            $dto = new CreateAssetDTO();
            $dto->setTenantId($company->tenant_id)
                ->setCompanyId($company->id)
                ->setMake(Arr::get($asset, 'make', null))
                ->setModel(Arr::get($asset, 'model', null))
                ->setTypeId(Arr::get($asset, 'type_id'))
                ->setSerialNumber(Arr::get($asset, 'serial_number'))
                ->setPurchasePrice(Arr::get($asset, 'purchase_price', null))
                ->setPurchaseDate(Arr::get($asset, 'purchase_date', null))
                ->setOfficeId(Arr::get($asset, 'office_id'))
                ->setOfficeAreaId(Arr::get($asset, 'office_area_id', null))
                ->setCurrency(Arr::get($asset, 'currency'))
                ->setMaintenanceCycle(Arr::get($asset, 'maintenance_cycle', null))
                ->setNextMaintenanceDate(Arr::get($asset, 'next_maintenance_date', null))
                ->setIsInsured(Arr::get($asset, 'is_insured', false))
                ->setAcquisitionType(Arr::get($asset, 'acquisition_type', null))
                ->setStatus(Arr::get($asset, 'status', AssetStatusEnum::PENDING_APPROVAL->value));

            if ($user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value, PermissionTypes::ASSET_CREATE_ACCESS->value])) {
                $dto->setStatus(AssetStatusEnum::AVAILABLE->value);
            }

            return $this->assetRepository->create($dto->toArray());
        });

        return $this->response(Response::HTTP_ACCEPTED, __("{$assets->count()} assets created"), $assets);
    }

    /**
     * @return JsonResponse
     */
    public function get(Company $company, Request $request)
    {
        $status = $request->get('status');
        $exclude = $request->get('exclude');

        $assets = $this->assetRepository->getCompanyAssets($company, $status);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assets);
    }

    public function getAssetMakes(Company $company)
    {
        $assetMakes = $this->assetMakeRepository->get(AssetMakeConstant::COMPANY_ID, $company->id);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $assetMakes);
    }

    public function createFromCSV(Company $company, Request $request)
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
        $asset = $this->assetRepository->firstWithRelation('id', $assetId, ['image', 'type', 'office', 'assignee', 'activities', 'tags']);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $asset);
    }

    public function getAssetOverview(Company $company, Asset $asset)
    {
        $asset = $this->assetRepository->firstWithRelation('id', $asset->id, ['image', 'type', 'office', 'officeArea', 'activities', 'assignee', 'vendor', 'documents']);

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
            case 'archive':
                return $this->markAssetAsArchived($asset);
            case 'details':
                return $this->updateAssetDetails($request, $asset, $company);

            default:
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.action-not-allowed'));
        }
    }

    public function archiveAsset(Request $request, Company $company, Asset $asset)
    {
        $asset->update([
            AssetConstant::STATUS => AssetStatusEnum::ARCHIVED->value
        ]);

        return $this->response(Response::HTTP_OK, __('messages.asset-archived'), $asset->fresh());
    }

    public function markAssetAsStolen(CreateStolenAsset $request, Company $company)
    {
        $dto = $request->getDTO()
            ->setCompanyId($company->id)
            ->setAssetId($request->asset_id);

        $stolenAsset = $this->assetRepository->markAsStolen($request->asset_id, $dto, $request->file('documents'));

        return $this->response(Response::HTTP_CREATED, __('messages.asset-marked-as-stolen'), $stolenAsset);
    }

    public function getStolenAssets(Request $request, Company $company)
    {
        $stolenAsset = $this->assetRepository->getCompanyStolenAssets($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $stolenAsset);
    }

    public function markAssetAsDamaged(CreateDamagedAssetRequest $request, Company $company, Asset $asset)
    {
        $dto = $request->getDTO()
            ->setCompanyId($company->id)
            ->setAssetId($request->asset_id);

        $damagedAsset = $this->assetRepository->markAsDamaged($request->asset_id, $dto, $request->file('documents'));

        return $this->response(Response::HTTP_CREATED, __('messages.asset-marked-as-damaged'), $damagedAsset);
    }

    public function getDamagedAssets(Request $request, Company $company)
    {
        $stolenAsset = $this->assetRepository->getCompanyDamagedAssets($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $stolenAsset);
    }

    public function markAssetAsRetired(CreateRetiredAssetRequest $request, Company $company)
    {
        $dto = $request->getDTO()
            ->setCompanyId($company->id);

        $retiredAsset = $this->assetRepository->markAsRetired($dto);

        return $this->response(Response::HTTP_CREATED, __('messages.asset-marked-as-retired'), $retiredAsset);
    }

    private function markAssetAsArchived(Asset $asset)
    {
        $archivedAsset = $this->assetRepository->markAsArchived($asset->id);

        return $this->response(Response::HTTP_OK, __('messages.asset-archived'), $archivedAsset);
    }

    public function uploadAssetImage(Request $request, Company $company, Asset $asset)
    {
        $this->validate($request, [
            'image' => 'required|image|max:5120',
        ]);

        $image = $request->file('image');

        $extension = $image->getClientOriginalExtension();

        $fileName = sprintf('%s/%s.%s', $asset->id, time(), $extension);

        if ($asset->image != null) {
            Storage::disk('s3')->delete($asset->image->path);
            $this->fileRepository->deleteById($asset->image->id);
        }

        $url = Storage::disk('s3')->putFileAs(config('filesystems.base-folder'), new File($image->getRealPath()), $fileName);

        if (!empty($url)) {
            $asset->image()->create(['path' => $url]);
        }

        return $this->response(Response::HTTP_OK, __('messages.asset-image-updated'), $asset->load('image'));
    }

    private function updateAssetDetails(Request $request, Asset $asset, Company $company)
    {
        $request->validate([
            'make' => 'nullable',
            'model' => 'nullable',
            'type_id' => ['nullable', Rule::exists('asset_types', 'id')],
            'serial_number' => 'nullable',
            'purchase_price' => ['nullable', 'decimal:2,4'],
            'purchase_date' => 'nullable|date',
            'office_id' => ['nullable', Rule::exists('offices', 'id')],
            'office_area_id' => ['nullable', Rule::exists('office_areas', 'id')],
            'currency' => ['nullable', Rule::exists('currencies', 'code')],
            'acquisition_type' => ['nullable', 'string'],
            'custom_tags' => ['nullable', 'array'],
            'vendor_id' => ['nullable', Rule::exists('vendors', 'id')],
            'assignee' => ['nullable', Rule::exists('users', 'id')],
            'condition' => ['nullable', 'string'],
            'maintenance_cycle' => ['nullable', 'string'],
            'next_maintenance_date' => ['nullable', 'date'],
        ]);

        if ($request->input('status') != null) {
            $user = $request->user();
            if (!$user->hasAnyPermission([PermissionTypes::ASSET_FULL_ACCESS->value, PermissionTypes::ASSET_CREATE_ACCESS->value])) {
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.only-admins-can-approve'));
            }

            if ($asset->status != AssetStatusEnum::PENDING_APPROVAL->value) {
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
            ->setVendorId($request->input('vendor_id') ?? null)
            ->setAcquisitionType($request->input('acquisition_type'))
            ->setCondition($request->input('condition'))
            ->setMaintenanceCycle($request->input('maintenance_cycle'))
            ->setNextMaintenanceDate($request->input('next_maintenance_date'))
            ->setAssignedTo($request->input('assignee'))
            ->setAssignedDate(Carbon::now())
            ->setStatus($request->input('status'));

        $this->assetRepository->updateById($asset->id, $dto->toSynthensizedArray());

        if (!empty($request->custom_tags)) {

            foreach ($request->custom_tags as $tag) {

                $this->tagRepository->assignTagtoAsset($asset, $tag);
            }

            $this->tagRepository->unAssignTagstoAsset($asset, $request->custom_tags);
        }

        $asset->refresh();

        return $this->response(Response::HTTP_OK, __('messages.asset-updated'), $asset);
    }

    public function assignAsset(Company $company, Asset $asset, User $user)
    {
        $asset->assignee()->associate($user);
        $asset->save();

        return $this->response(Response::HTTP_OK, __('messages.asset-assigned'), $asset);
    }

    public function unAssignAsset(Company $company, Asset $asset, User $user)
    {
        $asset->assignee()->dissociate($user);
        $asset->save();

        return $this->response(Response::HTTP_OK, __('messages.asset-unassigned'), $asset);
    }

    public function reAssignAsset(Company $company, Asset $asset, ReAssignAssetRequest $request)
    {
        $asset->assignee()->dissociate($request->from);
        $asset->assignee()->associate($request->to);
        $asset->save();

        return $this->response(Response::HTTP_OK, __('messages.asset-reassigned'), $asset);
    }

    public function reassignMultipleAsset(Company $company, Asset $asset, ReAssignMultipleAssetRequest $request)
    {
        $user = $request->assignee ? $request->assignee : null;
        $assignedDate = $request->assignee ? now() : null;

        foreach ($request->assets as $asset) {
            $asset = $this->assetRepository->first(AssetConstant::ID, $asset);
            $asset?->assignee()->associate($user);
            $asset->assigned_date = $assignedDate;
            $asset->save();
        }

        return $this->response(Response::HTTP_OK, __('messages.asset-reassigned'));
    }

    public function updateMultipleAsset(UpdateMultipleAssetsRequest $request)
    {
        $status = $request->get('status');

        $data = [
            AssetConstant::STATUS => $status,
        ];

        $assets = $this->assetRepository->updateMultiple(AssetConstant::ID, $request->assets, $data);

        if (!$assets) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'), $assets);
        }
        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $assets);
    }
}
