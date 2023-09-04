<?php

namespace App\Services\Contracts;

use App\Domains\DTO\Auction\CreatePaymentLinkDTO;

interface PaymentServiceInterface
{
    public static function getStandardPaymentLink(CreatePaymentLinkDTO $linkDTO);
}
