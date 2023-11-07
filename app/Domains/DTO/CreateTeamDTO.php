<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateTeamDTO
{
    use DTOToArray;

    private ?string $team_lead;
    private ?string $company_id;
    private ?string $tenant_id;
    private ?string $department_id;
    private ?string $name;

    public function getTeamLead(): ?string
    {
        return $this->team_lead;
    }

    public function setTeamLead(?string $team_lead): self
    {
        $this->team_lead = $team_lead;

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

    public function getDepartmentId(): ?string
    {
        return $this->department_id;
    }

    public function setDepartmentId(?string $department_id): self
    {
        $this->department_id = $department_id;

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
