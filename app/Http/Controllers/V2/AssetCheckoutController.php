<?php

namespace App\Http\Controllers\V2;

use App\Domains\DTO\Asset\AssetCheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\AssetCheckoutRequest;
use App\Http\Requests\Asset\UpdateAssetCheckoutRequest;
use App\Models\Asset;
use App\Models\AssetCheckout;
use App\Repositories\Contracts\AssetCheckoutRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AssetCheckoutController extends Controller
{
    public function __construct(private readonly AssetCheckoutRepositoryInterface $checkoutRepository)
    {
    }

    public function index()
    {
        $checkout = AssetCheckout::with('asset')->orderBy('group_id');
        $checkout = $checkout->paginate()->groupBy('group_id');

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $checkout);
    }

    public function show(AssetCheckout $asset_checkout)
    {
        $asset_checkout = $this->checkoutRepository->getAssetCheckout($asset_checkout);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $asset_checkout);
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

    public function update(UpdateAssetCheckoutRequest $request, AssetCheckout $asset_checkout)
    {
        $asset_checkout = $this->checkoutRepository->updateAssetCheckout($asset_checkout, $request->updateAssetDTO());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $asset_checkout);
    }
}
