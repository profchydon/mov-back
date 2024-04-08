<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;
use Illuminate\Support\Facades\Auth;

final class CreateDocumentDTO
{
    use DTOToArray;

    private string $name;
    private string $type;
    private string $extension;
    private string $user_id;
    private string $company_id;
    private ?string $registration_date;
    private ?string $expiration_date;
    private ?string $owner_id;

    public function __construct()
    {
        $this->user_id = Auth::id();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateDocumentDTO
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): CreateDocumentDTO
    {
        $this->type = $type;
        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): CreateDocumentDTO
    {
        $this->extension = $extension;
        return $this;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): CreateDocumentDTO
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getOwnerId(): ?string
    {
        return $this->owner_id;
    }

    public function setOwnerId(?string $owner_id): CreateDocumentDTO
    {
        $this->owner_id = $owner_id;
        return $this;
    }

    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    public function setCompanyId(string $company_id): CreateDocumentDTO
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function getRegistrationDate(): ?string
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(?string $registration_date): CreateDocumentDTO
    {
        $this->registration_date = $registration_date;
        return $this;
    }

    public function getExpirationDate(): ?string
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(?string $expiration_date): CreateDocumentDTO
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }
}
