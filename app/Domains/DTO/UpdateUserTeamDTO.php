<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class UpdateUserTeamDTO
{
    use DTOToArray;

    private array $teams;
    private string $company_id;
    private string $user_id;
    private string $department_id;

    public function setTeams(array $teams)
    {
        $this->teams = $teams;

        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
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

    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
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
}
