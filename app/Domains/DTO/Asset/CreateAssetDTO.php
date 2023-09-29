<?php

namespace App\Domains\DTO\Asset;

use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Domains\Enum\Maintenance\MaintenanceCycleEnum;
use App\Traits\DTOToArray;

final class CreateAssetDTO
{
    use DTOToArray;

    private ?string $make = null;
    private ?string $model = null;
    private string $type;
    private string $serial_number;
    private float $purchase_price;
    private ?string $purchase_date = null;
    private string $office_id;
    private ?string $office_area_id = null;
    private string $currency;
    private ?string $status;
    private ?string $maintenance_cycle = null;
    private ?string $next_maintenance_date = null;
    private bool $is_insured = false;
    private string $tenant_id;
    private ?string $company_id;
    private string $added_at;

    public function __construct()
    {
        $this->added_at = now();
        $this->status = AssetStatusEnum::AVAILABLE->value;
    }

     /**
     * @return string|null
     */
    public function getMake(): ?string
    {
        return $this->make;
    }

    /**
     * @param string|null $make
     * @return CreateAssetDTO
     */
    public function setMake(?string $make): CreateAssetDTO
    {
        $this->make = $make;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     * @return CreateAssetDTO
     */
    public function setModel(?string $model): CreateAssetDTO
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return CreateAssetDTO
     */
    public function setType(string $type): CreateAssetDTO
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serial_number;
    }

    /**
     * @param string $serial_number
     * @return CreateAssetDTO
     */
    public function setSerialNumber(string $serial_number): CreateAssetDTO
    {
        $this->serial_number = $serial_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getPurchasePrice(): string
    {
        return $this->purchase_price;
    }

    /**
     * @param string $purchase_price
     * @return CreateAssetDTO
     */
    public function setPurchasePrice(string $purchase_price): CreateAssetDTO
    {
        $this->purchase_price = $purchase_price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurchaseDate(): ?string
    {
        return $this->purchase_date;
    }

    /**
     * @param string|null $purchase_date
     * @return CreateAssetDTO
     */
    public function setPurchaseDate(?string $purchase_date): CreateAssetDTO
    {
        $this->purchase_date = $purchase_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getOfficeId(): string
    {
        return $this->office_id;
    }

    /**
     * @param string $office_id
     * @return CreateAssetDTO
     */
    public function setOfficeId(string $office_id): CreateAssetDTO
    {
        $this->office_id = $office_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOfficeAreaId(): ?string
    {
        return $this->office_area_id;
    }

    /**
     * @param string|null $office_area_id
     * @return CreateAssetDTO
     */
    public function setOfficeAreaId(?string $office_area_id): CreateAssetDTO
    {
        $this->office_area_id = $office_area_id;
        return $this;
    }

     /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return CreateAssetDTO
     */
    public function setCurrency(string $currency): CreateAssetDTO
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return CreateAssetDTO
     */
    public function setStatus(string $status): CreateAssetDTO
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaintenanceCycle(): string
    {
        return $this->maintenance_cycle;
    }

    /**
     * @param string $maintenance_cycle
     * @return CreateAssetDTO
     */
    public function setMaintenanceCycle(string | null $maintenance_cycle): CreateAssetDTO
    {
        $this->maintenance_cycle = $maintenance_cycle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNextMaintenanceDate(): ?string
    {
        return $this->next_maintenance_date;
    }

    /**
     * @param string|null $next_maintenance_date
     * @return CreateAssetDTO
     */
    public function setNextMaintenanceDate(?string $next_maintenance_date): CreateAssetDTO
    {
        $this->next_maintenance_date = $next_maintenance_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsInsured(): bool
    {
        return $this->is_insured;
    }

    /**
     * @param string $is_insured
     * @return CreateAssetDTO
     */
    public function setIsInsured(string $is_insured): CreateAssetDTO
    {
        $this->is_insured = $is_insured;
        return $this;
    }

    /**
     * @return string
     */
    public function getTenantId(): string
    {
        return $this->tenant_id;
    }

    /**
     * @param string $tenant_id
     * @return CreateAssetDTO
     */
    public function setTenantId(string $tenant_id): CreateAssetDTO
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    /**
     * @param string $company_id
     * @return CreateAssetDTO
     */
    public function setCompanyId(string $company_id): CreateAssetDTO
    {
        $this->company_id = $company_id;
        return $this;
    }
}
