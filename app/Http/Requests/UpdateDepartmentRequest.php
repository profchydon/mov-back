<?php

namespace App\Http\Requests;

use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'head_id' => ['sometimes', 'nullable', Rule::exists('users', 'id')->whereNull('deleted_at')],
        ];
    }
}
