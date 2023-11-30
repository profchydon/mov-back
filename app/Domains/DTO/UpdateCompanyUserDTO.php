<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class UpdateCompanyUserDTO
{
    use DTOToArray;

    private string $company_id;
    private string $user_id;
    private ?string $job_title;
    private ?string $employment_type;
    private ?string $office_id;
    private ?array $roles;
    private ?array $departments;
    private ?array $teams;

    public function setTeams(?array $teams)
    {
        $this->teams = $teams;

        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function setDepartments(?array $departments)
    {
        $this->departments = $departments;

        return $this;
    }

    public function getDepartments()
    {
        return $this->departments;
    }

    public function setRoles(?array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
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

    public function setJobTitle(?string $job_title)
    {
        $this->job_title = $job_title;

        return $this;
    }

    public function getJobTitle()
    {
        return $this->job_title;
    }

    public function setEmploymentType(?string $employment_type)
    {
        $this->employment_type = $employment_type;

        return $this;
    }

    public function getEmploymentType()
    {
        return $this->employment_type;
    }

    public function setOfficeId(?string $office_id)
    {
        $this->office_id = $office_id;

        return $this;
    }

    public function getOfficeId()
    {
        return $this->office_id;
    }
}
