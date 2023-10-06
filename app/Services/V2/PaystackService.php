<?php

namespace App\Services\V2;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Exceptions\FlutterwaveException;
use App\Exceptions\PaystackException;
use App\Services\Contracts\PaymentServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;

class PaystackService
{
    public static function getStandardPaymentLink(CreatePaymentLinkDTO $linkDTO)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PS_SECRET_KEY')
        ])->post(env('PS_BASE_URL') . "/transaction/initialize", [
            "email" => $linkDTO->getCustomer()['email'],
            'amount' => $linkDTO->getAmountInKobo(),
            'ref' => $linkDTO->getTxRef(),
            'callback_url' => $linkDTO->getRedirectUrl()
        ]);

        if (!$response->ok()) {
            throw new PaystackException(json_encode($response->json()));
        }

        return new Fluent($response->json('data'));
    }


    public static function getTransactionDetails(string $txRef)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PS_SECRET_KEY')
        ])->get(env('PS_BASE_URL') . "/transaction/verifY/{$txRef}");

        if(!$response->ok()){
            throw new PaystackException(json_encode($response->json()));
        }

        return new Fluent($response->json('data'));
    }
}
