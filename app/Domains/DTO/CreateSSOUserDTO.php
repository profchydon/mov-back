<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateSSOUserDTO
{
    use DTOToArray;

    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;


    public function __construct()
    {

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

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

}
