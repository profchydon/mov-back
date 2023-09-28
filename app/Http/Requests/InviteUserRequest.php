<?php

namespace App\Http\Requests;

use App\Domains\DTO\InviteCompanyUsersDTO;
use Illuminate\Foundation\Http\FormRequest;

class InviteUserRequest extends FormRequest
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
        return [
            'data' => 'required|array',
        ];
    }

    /**
     * @return array<int, InviteCompanyUsersDTO>
     */
    public function getInvitationData(string $companyId, string $userId): array
    {
        $DTOs = [];
        foreach ($this->data as $item) {
            $dto = new InviteCompanyUsersDTO();

            $dto->setEmail($item['email'])
                ->setRoleId($item['role_id'])
                ->setCompanyId($companyId)
                ->setInvitedBy($userId);

            $DTOs[] = $dto;
        }

        return $DTOs;
    }
}
