<?php

namespace App\Domains\DTO\Asset;

use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Traits\DTOToArray;
use Illuminate\Support\Carbon;

final class AssetCheckoutDTO
{
    use DTOToArray;

    private ?string $tenant_id;
    private ?string $company_id;
    private ?string $asset_id;
    private ?string $group_id;
    private ?string $reason;
    private ?string $receiver_type;
    private ?string $receiver_id;
    private ?Carbon $checkout_date;
    private ?Carbon $return_date;
    private ?string $comment;
    private ?string $status;

    public function getTenantId(): ?string
    {
        return $this->tenant_id;
    }

    public function setTenantId(?string $tenant_id): AssetCheckoutDTO
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    public function getCompanyId(): ?string
    {
        return $this->company_id;
    }

    public function setCompanyId(?string $company_id): AssetCheckoutDTO
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function getAssetId(): ?string
    {
        return $this->asset_id;
    }

    public function setAssetId(?string $asset_id): AssetCheckoutDTO
    {
        $this->asset_id = $asset_id;
        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->group_id;
    }

    public function setGroupId(?string $group_id): AssetCheckoutDTO
    {
        $this->group_id = $group_id;
        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): AssetCheckoutDTO
    {
        $this->reason = $reason;
        return $this;
    }

    public function getReceiverType(): ?string
    {
        return $this->receiver_type;
    }

    public function setReceiverType(?string $receiver_type): AssetCheckoutDTO
    {
        $this->receiver_type = $receiver_type;
        return $this;
    }

    public function getReceiverId(): ?string
    {
        return $this->receiver_id;
    }

    public function setReceiverId(?string $receiver_id): AssetCheckoutDTO
    {
        $this->receiver_id = $receiver_id;
        return $this;
    }

    public function getCheckoutDate(): ?Carbon
    {
        return $this->checkout_date;
    }

    public function setCheckoutDate(?Carbon $checkout_date): AssetCheckoutDTO
    {
        $this->checkout_date = $checkout_date;
        return $this;
    }

    public function getReturnDate(): ?Carbon
    {
        return $this->return_date;
    }

    public function setReturnDate(?Carbon $return_date): AssetCheckoutDTO
    {
        $this->return_date = $return_date;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): AssetCheckoutDTO
    {
        $this->comment = $comment;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): AssetCheckoutDTO
    {
        $this->status = $status;
        return $this;
    }


}
