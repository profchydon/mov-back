<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateUserDepartmentDTO
{
    use DTOToArray;

    private ?string $team_id;
    private ?string $company_id;
    private ?string $department_id;
    private array $members;

    public function setTeamId(?string $team_id)
    {
        $this->team_id = $team_id;

        return $this;
    }

    public function getTeamId()
    {
        return $this->team_id;
    }

    public function setMembers(array $members)
    {
        $this->members = $members;

        return $this;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function setDepartmentId(string $department_id)
    {
        $this->department_id = $department_id;

        return $this;
    }

    public function getDepartmentId()
    {
        return $this->department_id;
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
}
