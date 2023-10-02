<?php

namespace App\Domains\DTO\Asset;

use App\Traits\DTOToArray;

final class CreateAssetTypeDTO
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
