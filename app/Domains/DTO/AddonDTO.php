<?php

namespace App\Domains\DTO;

use Illuminate\Support\Collection;

final class AddonDTO
{
    private Collection $addOns;
    private string $currency_code;
    private string $redirect_uri;

    public function getAddOns(): Collection
    {
        return $this->addOns;
    }

    public function setAddOns(array $addOns): AddonDTO
    {
        $this->addOns = collect($addOns);
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency_code;
    }

    public function setCurrency(string $currency_code): AddonDTO
    {
        $this->currency_code = $currency_code;
        return $this;
    }

    public function getRedirectUri(): string
    {
        return $this->redirect_uri;
    }

    public function setRedirectUri(string $redirect_uri): AddonDTO
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }




}
