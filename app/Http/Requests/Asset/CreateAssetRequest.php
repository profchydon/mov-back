<?php

namespace App\Http\Requests\Asset;

use App\Domain\DTO\Asset\CreateAssetDTO;
use App\Rules\HumanNameRule;
use App\Rules\RaydaStandardPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|array',
            'company.email' => 'required|email|unique:companies,email',
            'user' => 'required|array',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => ['required', new RaydaStandardPasswordRule()],
            'user.first_name' => ['required', new HumanNameRule()],
            'user.last_name' => ['required', new HumanNameRule()],
        ];
    }

    public function creatAssetDTO(): CreateAssetDTO
    {
        $dto = new CreateAssetDTO();
        $dto->setMake($this->input('make', ''))
            ->setModel($this->input('model', ''))
            ->setType($this->input('type'))
            ->setPurchasePrice($this->input('purchase_price', ''))
            ->setPurchaseDate($this->input('purchase_date', ''))
            ->setOfficeId($this->input('office_id'))
            ->setOfficeAreaId($this->input('office_area_id', ''))
            ->setCurrency($this->input('currency'))
            ->setMaintenanceCycle($this->input('maintenance_cycle', ''))
            ->setNextMaintenanceDate($this->input('next_maintenance_date', ''))
            ->setIsInsured($this->input('is_insured', false))
            ->setCompanyId($this->input('company_id'))
            ;

        return $dto;
    }

}
