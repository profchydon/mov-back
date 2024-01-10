<?php

namespace App\Domains\DTO;

use App\Domains\Enum\User\UserStageEnum;
use App\Traits\DTOToArray;

class CreateUserDTO
{
    use DTOToArray;

    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone;
    private string $country_id;
    private string $password;
    private string $tenant_id;
    private string $stage;
    private string $sso_id;
    private ?string $job_title = null;
    private ?string $employment_type;
    private ?string $office_id;

    public function __construct()
    {
        $this->stage = UserStageEnum::VERIFICATION->value;
    }

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

    public function setCountryId(string $country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getCountryId()
    {
        return $this->country_id;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setStage(string $stage)
    {
        $this->stage = $stage;

        return $this;
    }

    public function getStage()
    {
        return $this->stage;
    }

    public function setTenantId(string $tenant_id)
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    public function getTenantId()
    {
        return $this->tenant_id;
    }

    public function setSsoId(string $sso_id)
    {
        $this->sso_id = $sso_id;

        return $this;
    }

    public function getSsoId()
    {
        return $this->sso_id;
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
