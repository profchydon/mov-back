<?php

namespace App\Http\Requests;

use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', new HumanNameRule(), Rule::unique('departments', 'name')->where('company_id', $this->route('company')->id)],
            'head_id' => ['sometimes', 'nullable', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'members' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
