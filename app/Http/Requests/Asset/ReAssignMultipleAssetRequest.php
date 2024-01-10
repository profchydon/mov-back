<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReAssignMultipleAssetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'assignee' => ['nullable', Rule::exists('users', 'id')],
            'assets' => ['required', Rule::exists('assets', 'id')],
        ];
    }
}
