<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateDepartmentDTO
{
    use DTOToArray;

    private ?string $head_id;
    private ?string $company_id;
    private ?string $tenant_id;
    private ?string $name;

    public function getHeadId(): ?string
    {
        return $this->head_id;
    }

    public function setHeadId(?string $head_id): self
    {
        $this->head_id = $head_id;

        return $this;
    }

    public function getCompanyId(): ?string
    {
        return $this->company_id;
    }

    public function setCompanyId(?string $company_id): self
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenant_id;
    }

    public function setTenantId(?string $tenant_id): self
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
