<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('teams', 'name')->where('department_id', $this->route('department')->id)],
            'team_lead' => ['sometimes', 'nullable', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'members' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
