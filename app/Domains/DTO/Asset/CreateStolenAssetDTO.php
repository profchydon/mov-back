<?php

namespace App\Domains\DTO\Asset;

use App\Traits\DTOToArray;

final class CreateStolenAssetDTO
{
    use DTOToArray;

    private string $date;
    private string $comment;
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

    public function setComment(string $comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
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
