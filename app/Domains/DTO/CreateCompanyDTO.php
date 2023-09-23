<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateCompanyDTO
{
    use DTOToArray;
    
    private string $name;
    private string $size;
    private string $industry;
    private string $address;
    private string $country;
    private string $state;
    private string $tenant_id;

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSize(string $size)
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setIndustry(string $industry)
    {
        $this->industry = $industry;
        return $this;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setState(string $state)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setTenantId(string $tenantId)
    {
        $this->tenant_id = $tenantId;
        return $this;
    }

    public function getTenantId()
    {
        return $this->tenant_id;
    }
}