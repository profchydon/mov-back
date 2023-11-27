<?php

namespace App\Http\Requests;

use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Rules\UserHasRoleForSeatAssignment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RevokeSeatFromUserRequest extends FormRequest
{

    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'user_ids' => ['required','array', 'min:1'],
            'user_ids.*' => ['required', Rule::exists('user_companies', 'user_id')->where('company_id', $company->id)->where('status', UserCompanyStatusEnum::ACTIVE)]
        ];
    }
}
