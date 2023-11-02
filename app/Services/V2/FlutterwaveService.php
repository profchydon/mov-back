<?php

namespace App\Services\V2;

use App\Domains\DTO\CreatePaymentLinkDTO;
use App\Exceptions\FlutterwaveException;
use App\Services\Contracts\PaymentServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;

class FlutterwaveService implements PaymentServiceInterface
{
    public static function getStandardPaymentLink(CreatePaymentLinkDTO $linkDTO)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY')
        ])->post(env('FLW_BASE_URL') . "/payments", $linkDTO->toArray());

        if (!$response->ok()) {
            throw new FlutterwaveException(json_encode($response->json()));
        }

        return new Fluent($response->json('data'));
    }


    public static function getTransactionDetails(string $txRef)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY')
        ])->get(env('FLW_BASE_URL') . "/transactions/verify_by_reference", [
            'tx_ref' => $txRef
        ]);

        return $response->json();
    }
}
