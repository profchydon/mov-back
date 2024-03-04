<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

final class InsuranceDTO
{
    use DTOToArray;

    private string $provider;
    private string $policy_id;
    private string $company_id;
    private string $tenant_id;
    private string $purchase_date;
    private string $expiration_date;
    private float $max_num_assets;
    private ?string $asset_premium;
    private ?string $coverage_percentage;
    private ?string $coverage_cycle;
    private ?string $country;

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): InsuranceDTO
    {
        $this->provider = $provider;
        return $this;
    }

    public function getPolicyId(): string
    {
        return $this->policy_id;
    }

    public function setPolicyId(string $policy_id): InsuranceDTO
    {
        $this->policy_id = $policy_id;
        return $this;
    }

    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    public function setCompanyId(string $company_id): InsuranceDTO
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function getTenantId(): string
    {
        return $this->tenant_id;
    }

    public function setTenantId(string $tenant_id): InsuranceDTO
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    public function getPurchaseDate(): string
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(string $purchase_date): InsuranceDTO
    {
        $this->purchase_date = $purchase_date;
        return $this;
    }

    public function getExpirationDate(): string
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(string $expiration_date): InsuranceDTO
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }

    public function getMaxNumAssets(): float
    {
        return $this->max_num_assets;
    }

    public function setMaxNumAssets(float $max_num_assets): InsuranceDTO
    {
        $this->max_num_assets = $max_num_assets;
        return $this;
    }

    public function getAssetPremium(): ?string
    {
        return $this->asset_premium;
    }

    public function setAssetPremium(?string $asset_premium): InsuranceDTO
    {
        $this->asset_premium = $asset_premium;
        return $this;
    }

    public function getCoveragePercentage(): ?string
    {
        return $this->coverage_percentage;
    }

    public function setCoveragePercentage(?string $coverage_percentage): InsuranceDTO
    {
        $this->coverage_percentage = $coverage_percentage;
        return $this;
    }

    public function getCoverageCycle(): ?string
    {
        return $this->coverage_cycle;
    }

    public function setCoverageCycle(?string $coverage_cycle): InsuranceDTO
    {
        $this->coverage_cycle = $coverage_cycle;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): InsuranceDTO
    {
        $this->country = $country;
        return $this;
    }


}
