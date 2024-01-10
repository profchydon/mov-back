<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

final class CreateCompanyOfficeDTO
{
    use DTOToArray;

    private ?string $company_id;
    private ?string $tenant_id;
    private ?string $name;
    private ?string $street_address;
    private ?string $state;
    private ?string $country;
    private ?float $longitude;
    private ?float $latitude;
    private ?string $currency_code;

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    public function setCompanyId(?string $company_id): self
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getTenantId(): string
    {
        return $this->tenant_id;
    }

    public function setTenantId(?string $tenant_id): self
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreetAddress(): string
    {
        return $this->street_address;
    }

    public function setStreetAddress(?string $street_address): self
    {
        $this->street_address = $street_address;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    public function setCurrencyCode(?string $currency_code): self
    {
        $this->currency_code = $currency_code;

        return $this;
    }
}
