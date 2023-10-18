<?php

namespace App\Http\Controllers\V2;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\AssetCheckoutRequest;
use App\Models\Asset;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AssetCheckoutController extends Controller
{
    public function __construct(private readonly AssetCheckoutRepositoryInterface $checkoutRepository)
    {
    }

    public function store(AssetCheckoutRequest $request)
    {
        $assets = collect($request->assets);
        $assets = $assets->transform(fn ($asset) => Asset::find($asset));

        $groupId = strtolower(uniqid());

        $assets = $assets->transform(function ($asset) use ($request, $groupId) {
            $dto = new AssetCheckoutDTO();
            $dto->setTenantId($asset->tenant_id)
                ->setCompanyId($asset->company_id)
                ->setAssetId($asset->id)
                ->setReason($request->reason)
                ->setComment($request->comment)
                ->setReceiverType($request->receiver_type)
                ->setReceiverId($request->receiver_id)
                ->setReturnDate(Carbon::createFromFormat('Y-m-d', $request->return_date))
                ->setCheckoutDate(Carbon::createFromFormat('Y-m-d', $request->checkout_date))
                ->setGroupId($groupId);

            return $this->checkoutRepository->checkoutAsset($dto);
        });

        return $this->response(Response::HTTP_OK, __('messages.record-created'), $assets);
    }
}
