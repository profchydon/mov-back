<?php

namespace App\Domains\DTO\Asset;

use App\Traits\DTOToArray;
use Illuminate\Support\Carbon;

final class AssetReturnDTO
{
    use DTOToArray;


    private ?string $return_note;
    private ?Carbon $date_returned;
    private array $assets;
    private string $groupId;

    public function getReturnNote(): ?string
    {
        return $this->return_note;
    }

    public function setReturnNote(?string $return_note): self
    {
        $this->return_note = $return_note;

        return $this;
    }

    public function getDateReturned(): ?Carbon
    {
        return $this->date_returned;
    }

    public function setDateReturned(?string $date_returned): self
    {
        $this->date_returned = $date_returned;

        return $this;
    }

    public function getAssets(): ?array
    {
        return $this->assets;
    }

    public function setAssets(?array $assets): self
    {
        $this->assets = $assets;

        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(string $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }
}
