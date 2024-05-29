<?php

namespace App\Http\Requests\Asset;

use App\Domains\Enum\Asset\AssetAcquisitionTypeEnum;
use App\Domains\Enum\Asset\AssetConditionEnum;
use App\Domains\Enum\Maintenance\MaintenanceCycleEnum;
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
            'assets.*.make' => 'required',
            'assets.*.model' => 'required',
            'assets.*.type_id' => ['required', Rule::exists('asset_types', 'id')],
            'assets.*.serial_number' => 'required',
            'assets.*.purchase_price' => ['required', 'decimal:2,4'],
            'assets.*.purchase_date' => 'nullable|date',
            'assets.*.office_id' => ['sometimes', Rule::exists('offices', 'id')->where('company_id', $company->id)],
            'assets.*.currency' => ['required', Rule::exists('currencies', 'code')],
            'assets.*.maintenance_cycle' => ['nullable', Rule::in(MaintenanceCycleEnum::values())],
            'assets.*.next_maintenance_date' => 'nullable|date',
            'assets.*.acquisition_type' => ['nullable', Rule::in(AssetAcquisitionTypeEnum::values())],
            'assets.*.condition' => ['nullable', Rule::in(AssetConditionEnum::values())],
            'assets.*.assignee_email_address' => 'nullable|email',
        ];
    }
}
