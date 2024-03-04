<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsureAssetRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'assets' => 'required|array|min:1',
            'assets.*' => ['required', Rule::exists('assets', 'id')->whereNull('deleted_at')]
        ];
    }
}
