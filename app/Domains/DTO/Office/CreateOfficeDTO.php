<?php

namespace App\Domains\DTO\Office;

use App\Traits\DTOToArray;

final class CreateOfficeDTO
{
    use DTOToArray;

    private string $name;
    private string $address;
    private string $currency_id;
    private string $country;
    private ?string $state = null;
    private string $latitude;
    private string $longitude;
    private string $status;
    private string $tenant_id;
    private string $company_id;
}
