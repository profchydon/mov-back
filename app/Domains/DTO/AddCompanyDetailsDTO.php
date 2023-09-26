<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class AddCompanyDetailsDTO
{
    use DTOToArray;

    private string $name;
    private string $size;
    private string $industry;
    private string $address;

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
}
