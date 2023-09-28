<?php

namespace App\Domains\DTO\Asset;

use App\Domains\Enum\Asset\AssetTypeStatusEnum;
use App\Traits\DTOToArray;

class CreateAssetTypeDTO
{
    use DTOToArray;

    private string $name;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
