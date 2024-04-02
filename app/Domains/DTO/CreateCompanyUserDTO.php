<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateCompanyUserDTO
{
    use DTOToArray;

    private string $first_name;
    private string $last_name;
    private string $email;
    private string $job_title;
    private string $employment_type;
    private int $role_id;
    private ?string $office_id;
    private ?string $department_id;
    private ?string $team_id;
    private string $code;
    private string $company_id;
    private ?string $tenant_id;
    private string $invited_by;
    private ?bool $allow_user_login;

    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setJobTitle(string $job_title)
    {
        $this->job_title = $job_title;

        return $this;
    }

    public function getJobTitle()
    {
        return $this->job_title;
    }

    public function setEmploymentType(string $employment_type)
    {
        $this->employment_type = $employment_type;

        return $this;
    }

    public function getEmploymentType()
    {
        return $this->employment_type;
    }

    public function setRoleId(int $role_id)
    {
        $this->role_id = $role_id;

        return $this;
    }

    public function getRoleId()
    {
        return $this->role_id;
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

    public function setDepartmentId(?string $department_id)
    {
        $this->department_id = $department_id;

        return $this;
    }

    public function getDepartmentId()
    {
        return $this->department_id;
    }

    public function setTeamId(?string $team_id)
    {
        $this->team_id = $team_id;

        return $this;
    }

    public function getTeamId()
    {
        return $this->team_id;
    }

    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
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

    public function setTenantId(?string $tenant_id)
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    public function getTenantId()
    {
        return $this->tenant_id;
    }

    public function setInvitedBy(string $invited_by)
    {
        $this->invited_by = $invited_by;

        return $this;
    }

    public function getInvitedBy()
    {
        return $this->invited_by;
    }

    public function setAllowUserLogin(?bool $allow_user_login)
    {
        $this->allow_user_login = $allow_user_login;

        return $this;
    }

    public function getAllowUserLogin()
    {
        return $this->allow_user_login;
    }
}
