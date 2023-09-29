<?php

namespace App\Http\Requests\Asset;

use App\Domain\DTO\Asset\CreateAssetDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company' => 'required|array',
        ];
    }


    public function assetDTO(): CreateAssetDTO
    {
        $dto = new CreateAssetDTO();
        $dto->setMake($this->input('make', ''))
            ->setModel($this->input('model', ''))
            ->setType($this->input('type', ''))
            ->setPurchasePrice($this->input('purchase_price',''))
            ->setPurchaseDate($this->input('purchase_date', ''))
            ->setOfficeId($this->input('office_id', ''))
            ->setOfficeAreaId($this->input('office_area_id', ''))
            ->setCurrency($this->input('currency', ''))
            ->setStatus($this->input('status', ''))
            ->setMaintenanceCycle($this->input('maintenance_cycle', ''))
            ->setNextMaintenanceDate($this->input('next_maintenance_date', ''))
            ->setIsInsured($this->input('is_insured', ''));

        return $dto;
    }
}
