<?php

namespace App\Domains\DTO;

use App\Domains\Enum\Tenant\TenantStatusEnum;
use App\Traits\DTOToArray;

class CreateTenantDTO
{
    use DTOToArray;

    private ?string $name = null;
    private string $email;
    private ?string $sub_domain = null;
    private string $status;

    public function __construct()
    {
        $this->status = TenantStatusEnum::ACTIVE->value;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSubdomain(?string $sub_domain)
    {
        $this->sub_domain = $sub_domain;

        return $this;
    }

    public function getSubdomain()
    {
        return $this->sub_domain;
    }
}
