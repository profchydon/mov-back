<?php

namespace App\Http\Requests\Asset;

use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAssetFromArrayRequest extends FormRequest
{
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'assets' => ['required', 'array'],
            'assets.*.make' => ['nullable', new HumanNameRule()],
            'assets.*.model' => ['nullable', new HumanNameRule()],
            'assets.*.type_id' => ['required', Rule::exists('asset_types', 'id')],
            'assets.*.serial_number' => 'required|string',
            'assets.*.purchase_price' => ['required', 'decimal:2,4'],
            'assets.*.purchase_date' => 'nullable|date',
            'assets.*.office_id' => ['required', Rule::exists('offices', 'id')->where('company_id', $company->id)],
            'assets.*.currency' => ['required', Rule::exists('currencies', 'code')],
        ];
    }
}
