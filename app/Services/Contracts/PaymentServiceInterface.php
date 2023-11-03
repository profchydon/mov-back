<?php

namespace App\Services\Contracts;

use App\Domains\DTO\CreatePaymentLinkDTO;

interface PaymentServiceInterface
{
    public static function getStandardPaymentLink(CreatePaymentLinkDTO $linkDTO);
}
