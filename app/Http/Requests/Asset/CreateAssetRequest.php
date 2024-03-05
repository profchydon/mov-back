<?php

namespace App\Http\Requests\Asset;

use App\Domains\Constant\CompanyConstant;
use App\Domains\DTO\Asset\CreateAssetDTO;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAssetRequest extends FormRequest
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
            // Rule::exists(Company::class, CompanyConstant::ID),
            'make' => 'nullable',
            'model' => 'nullable',
            'type_id' => ['required', Rule::exists('asset_types', 'id')],
            'serial_number' => 'required',
            'purchase_price' => ['required', 'decimal:2,4'],
            'purchase_date' => 'nullable|date',
            'office_id' => ['required', Rule::exists('offices', 'id')->where('company_id', $company->id)],
            'currency' => ['required', Rule::exists('currencies', 'code')],
            'assigned_to' => ['nullable', Rule::exists('users', 'id')],
        ];
    }

    public function createAssetDTO(): CreateAssetDTO
    {
        $company = $this->route('company');
        $dto = new CreateAssetDTO();
        $dto->setMake($this->input('make', null))
            ->setModel($this->input('model', null))
            ->setTypeId($this->input('type_id'))
            ->setSerialNumber($this->input('serial_number'))
            ->setPurchasePrice($this->input('purchase_price', null))
            ->setPurchaseDate($this->input('purchase_date', null))
            ->setOfficeId($this->input('office_id'))
            ->setOfficeAreaId($this->input('office_area_id', null))
            ->setCurrency($this->input('currency'))
            ->setMaintenanceCycle($this->input('maintenance_cycle', null))
            ->setNextMaintenanceDate($this->input('next_maintenance_date', null))
            ->setIsInsured($this->input('is_insured', false))
            ->setAssignedTo($this->input('assignee', null))
            ->setMaintenanceCycle($this->input('maintenance_cycle', null))
            ->setCompanyId($company->id)
            ->setStatus(AssetStatusEnum::PENDING_APPROVAL->value);

        return $dto;
    }
}
