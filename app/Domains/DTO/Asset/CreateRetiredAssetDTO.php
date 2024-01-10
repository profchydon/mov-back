<?php

namespace App\Domains\DTO\Asset;

use App\Traits\DTOToArray;

final class CreateRetiredAssetDTO
{
    use DTOToArray;

    private string $date;
    private string $reason;
    private string $company_id;
    private string $asset_id;

    public function setDate(string $date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setReason(string $reason)
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setCompanyId(string $company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function setAssetId(string $asset_id)
    {
        $this->asset_id = $asset_id;

        return $this;
    }

    public function getAssetId()
    {
        return $this->asset_id;
    }
}
