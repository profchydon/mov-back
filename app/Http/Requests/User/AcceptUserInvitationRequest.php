<?php

namespace App\Http\Requests\User;

use App\Domains\Constant\UserInvitationConstant;
use App\Domains\DTO\CreateSSOUserDTO;
use App\Domains\DTO\CreateUserDTO;
use App\Domains\Enum\User\UserStageEnum;
use App\Rules\HumanNameRule;
use App\Rules\RaydaStandardPasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AcceptUserInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $code = $this->route('code');

        return [
            'email' => 'required|email|unique:users,email',
            'email' => Rule::exists('user_invitations', UserInvitationConstant::EMAIL)->where(UserInvitationConstant::CODE, $code),
            'password' => ['required', new RaydaStandardPasswordRule()],
            'first_name' => ['required', new HumanNameRule()],
            'last_name' => ['required', new HumanNameRule()],
        ];
    }

    public function getUserDTO(): CreateUserDTO
    {
        $dto = new CreateUserDTO();
        $dto->setFirstName($this->first_name)
            ->setLastName($this->last_name)
            ->setEmail($this->email)
            ->setPassword($this->password)
            ->setJobTitle($this->job_title, null)
            ->setStage(UserStageEnum::COMPLETED->value);

        return $dto;
    }

    public function getSSOUserDTO(): CreateSSOUserDTO
    {
        $dto = new CreateSSOUserDTO();
        $dto->setFirstName($this->first_name)
            ->setLastName($this->last_name)
            ->setEmail($this->email)
            ->setPassword($this->password);

        return $dto;
    }


    // public function getUserCompanyDTO(): CreateUserDTO
    // {
    //     $dto = new CreateUserDTO();
    //     $dto->setFirstName($this->first_name)
    //         ->setLastName($this->last_name)
    //         ->setEmail($this->email)
    //         ->setPassword($this->password);

    //     return $dto;
    // }
}
