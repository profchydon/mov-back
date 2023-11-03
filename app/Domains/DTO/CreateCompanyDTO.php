<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateCompanyDTO
{
    use DTOToArray;

    private string $name;
    private string $email;
    private ?string $phone;
    private ?string $size;
    private ?string $industry;
    private ?string $address;
    private ?string $country;
    private ?string $state;
    private string $tenant_id;
    private string $sso_id;
    private string $invitation_code;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
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

    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setSize(?string $size)
    {
        $this->size = $size;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setIndustry(?string $industry)
    {
        $this->industry = $industry;

        return $this;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function setAddress(?string $address)
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCountry(?string $country)
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setState(?string $state)
    {
        $this->state = $state;

        return $this;
    }

    public function getState()
    {
        return $this->state;
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

    public function setInvitationCode(string $invitation_code)
    {
        $this->invitation_code = $invitation_code;
        return $this;
    }

    public function getInvitationCode()
    {
        return $this->invitation_code;
    }
}
