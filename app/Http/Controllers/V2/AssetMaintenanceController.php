<?php

namespace App\Http\Controllers\V2;

use App\Domains\DTO\Asset\AssetMaintenanceDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\AssetMaintenanceRequest;
use App\Models\Asset;
use App\Models\Company;
use App\Repositories\Contracts\AssetMaintenanceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AssetMaintenanceController extends Controller
{
    public function __construct(private readonly AssetMaintenanceRepositoryInterface $maintenanceRepository)
    {
    }

    public function index(Company $company, Request $request)
    {
        $maintenance = $this->maintenanceRepository->getMaintenanceLogs($company);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $maintenance);
    }

    public function store(Company $company, AssetMaintenanceRequest $request)
    {
        $assets = collect($request->assets);
        $assets = $assets->transform(fn ($asset) => Asset::find($asset));

        $groupId = strtolower(uniqid());
        $assets = $assets->transform(function ($asset) use ($request, $groupId) {
            $dto = new AssetMaintenanceDTO();
            $dto->setCompanyId($asset->company_id)
                ->setTenantId($asset->tenant_id)
                ->setAssetId($asset->id)
                ->setReceiverId($request->receiver_id)
                ->setGroupId($groupId)
                ->setComment($request->comment)
                ->setReason($request->reason)
                ->setReturnDate(Carbon::createFromFormat('Y-m-d', $request->return_date))
                ->setScheduledDate(Carbon::createFromFormat('Y-m-d', $request->scheduled_date));

            return $this->maintenanceRepository->createMaintenanceLog($dto);
        });

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $assets);
    }

    public function getAssetMaintenance(Company $company, Asset $asset)
    {
        $maintenance = $this->maintenanceRepository->getAssetMaintenance($asset);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $maintenance);
    }
}
