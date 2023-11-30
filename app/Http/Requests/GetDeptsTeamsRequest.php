<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetDeptsTeamsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'departments' => ['sometimes', 'array', Rule::exists('departments', 'id')],
        ];
    }
}
