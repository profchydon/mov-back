<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;
use Illuminate\Support\Facades\Auth;

final class UpdateDocumentDTO
{
    use DTOToArray;

    private ?string $name;
    private ?string $type;
    private ?string $registration_date;
    private ?string $expiration_date;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getRegistrationDate(): ?string
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(?string $registration_date): self
    {
        $this->registration_date = $registration_date;
        return $this;
    }

    public function getExpirationDate(): ?string
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(?string $expiration_date): self
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }
}
