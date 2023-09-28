<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

final class CreateCompanyOfficeDTO
{
    use DTOToArray;

    private string $company_id;
    private string $tenant_id;
    private string $name;
    private string $street_address;
    private string $state;
    private string $country;
    private float $longitude;
    private float $latitude;
    private string $currency_code;

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    /**
     * @param string $company_id
     * @return CreateCompanyOfficeDTO
     */
    public function setCompanyId(string $company_id): self
    {
        $this->company_id = $company_id;

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
     * @return CreateCompanyOfficeDTO
     */
    public function setTenantId(string $tenant_id): self
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateCompanyOfficeDTO
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->street_address;
    }

    /**
     * @param string $street_address
     * @return CreateCompanyOfficeDTO
     */
    public function setStreetAddress(string $street_address): self
    {
        $this->street_address = $street_address;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return CreateCompanyOfficeDTO
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return CreateCompanyOfficeDTO
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return CreateCompanyOfficeDTO
     */
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return CreateCompanyOfficeDTO
     */
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     * @return CreateCompanyOfficeDTO
     */
    public function setCurrencyCode(string $currency_code): self
    {
        $this->currency_code = $currency_code;

        return $this;
    }
}
