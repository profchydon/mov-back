<?php

namespace App\Http\Requests;

use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserDepartmentRequest extends FormRequest
{
    public function rules(): array
    {

        $company = $this->route('company');
        $department = $this->route('department');

        return [
            'members' => ['required', 'array'],
            'team_id' => ['sometimes', 'nullable', Rule::exists('teams', 'id')],
        ];
    }
}
