<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateSSOCompanyDTO
{
    use DTOToArray;

    private object $company;
    private object $user;

    public function setCompany(object $company)
    {
        $this->company = $company;
        return $this;
    }

    public function getCompany(): object
    {
        return $this->company;
    }

    public function setUser(object $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(): object
    {
        return $this->user;
    }
}
