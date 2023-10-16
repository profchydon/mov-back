<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\AssetMakeConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Models\Asset;
use App\Repositories\Contracts\AssetMakeRepositoryInterface;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Rules\HumanNameRule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


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
                if(!$image){
                    return $this->error(Response::HTTP_BAD_REQUEST, __('messages.provide-asset-image'));
                }

                return $this->uploadAssetImage($request->image, $asset);
            case 'details':
                return $this->updateAssetDetails($request, $asset);

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
            'type_id' => ['required', Rule::exists('asset_types', 'id')],
            'serial_number' => 'required|string',
            'purchase_price' => ['required', 'decimal:2,4'],
            'purchase_date' => 'nullable|date',
            'office_id' => ['required', Rule::exists('offices', 'id')],
            'currency' => ['required', Rule::exists('currencies', 'code')],
        ]);

        $dto = new CreateAssetDTO();
        $dto->setMake($request->input('make'))
            ->setModel($request->input('model'))
            ->setTypeId($request->input('type_id'))
            ->setSerialNumber($request->input('serial_number'))
            ->setPurchasePrice($request->input('purchase_price'))
            ->setPurchaseDate($request->input('purchase_date'))
            ->setOfficeId($request->input('office_id'))
            ->setCurrency($request->input('currency'));

        $this->assetRepository->updateById($asset->id, $dto->toSynthensizedArray());

        return $this->response(Response::HTTP_OK, __('messages.asset-updated'));
    }
}
