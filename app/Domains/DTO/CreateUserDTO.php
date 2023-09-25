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
    private string $stage = UserStageEnum::VERIFICATION->value;
    private string $sso_id;
    
    public function setFirstName(string $first_name){
        $this->first_name = $first_name;
        return $this;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function setLastName(string $last_name){
        $this->last_name = $last_name;
        return $this;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function setEmail(string $email){
        $this->email = $email;
        return $this;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setCountryId(string $country_id){
        $this->country_id = $country_id;
        return $this;
    }

    public function getCountryId(){
        return $this->country_id;
    }

    public function setPhone(string $phone){
        $this->phone = $phone;
        return $this;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPassword(string $password){
        $this->password = $password;
        return $this;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setStage(string $stage){
        $this->stage = $stage;
        return $this;
    }

    public function getStage(){
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
}
