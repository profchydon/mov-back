<?php

namespace App\Domains\DTO;

use App\Models\User;

final class CreatePaymentLinkDTO
{
    private string $tx_ref;
    private float $amount;
    private string $currency;
    private ?string $redirect_url;
    private array $meta = [];
    private array $customer;

    public function __construct()
    {
        $this->currency = 'NGN';
        $this->tx_ref = uniqid('tx_ref_');
        $this->redirect_url = route('flutterwave.callback');
    }

    public function toArray(): array
    {
        $values = [];
        foreach ($this as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }

    public function getTxRef(): string
    {
        return $this->tx_ref;
    }

    public function setTxRef(string $tx_ref): self
    {
        $this->tx_ref = $tx_ref;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAmountInKobo(): float
    {
        return $this->amount * 100;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        if (!empty($currency)) {
            $this->currency = $currency;
        }

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirect_url;
    }

    public function setRedirectUrl(?string $redirect_url): self
    {
        if (!empty($redirect_url)) {
            $this->redirect_url = $redirect_url;
        }

        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getCustomer(): array
    {
        return $this->customer;
    }

    public function setCustomer(User $customer): self
    {
        $this->customer = [
            'email' => $customer->email,
            'phoneNumber' => $customer->phone,
            'name' => "{$customer->first_name} {$customer->last_name}",
        ];

        return $this;
    }
}
