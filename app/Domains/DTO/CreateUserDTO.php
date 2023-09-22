<?php

namespace App\Domains\DTO;

use App\Domains\Enum\User\UserAccountStageEnum;
use App\Traits\DTOToArray;

class CreateUserDTO
{
    use DTOToArray;

    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone_code;
    private string $phone;
    private string $password;
    private string $stage = UserAccountStageEnum::VERIFICATION->value;

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

    public function setPhoneCode(string $phone_code){
        $this->phone_code = $phone_code;
        return $this;
    }

    public function getPhoneCode(){
        return $this->phone_code;
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
}