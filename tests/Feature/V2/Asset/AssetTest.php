<?php

use App\Models\Asset;
use App\Models\Office;
use App\Models\Company;
use App\Models\Currency;
use App\Models\AssetType;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Repositories\AssetRepository;
use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;

beforeEach(function () {

    $this->baseUrl = config('app.url');
    $this->make = ['Apple', 'Samsung'];
    $this->model = ['Iphone', 'Galaxy'];
    $this->assetRepository = new AssetRepository();
    $this->company = Company::factory()->create();
    $this->asset_type = AssetType::factory()->create();
    $this->office = Office::factory()->create([
        OfficeConstant::TENANT_ID => $this->company->tenant_id,
        OfficeConstant::COMPANY_ID => $this->company->id,
    ]);

    $this->currency = Currency::factory()->create()->inRandomOrder()->first();

    $this->payload = [
        AssetConstant::TENANT_ID => $this->company->tenant_id,
        AssetConstant::COMPANY_ID => $this->company->id,
        AssetConstant::TYPE_ID => $this->asset_type->id,
        AssetConstant::MAKE => $this->make[array_rand($this->make)],
        AssetConstant::MODEL => $this->model[array_rand($this->model)],
        AssetConstant::SERIAL_NUMBER => Str::random(10),
        AssetConstant::OFFICE_ID => $this->office->id,
        AssetConstant::PURCHASE_PRICE => "300000.00",
        AssetConstant::CURRENCY => $this->currency->code,
        AssetConstant::ADDED_AT => now(),
        AssetConstant::STATUS => AssetStatusEnum::AVAILABLE->value
    ];
});

test('create single asset', function () {

    $response = $this->post("http://localhost:80/api/v2/companies/{$this->company->id}/assets", $this->payload);
    $response->assertStatus(Response::HTTP_CREATED);
    $this->assertDatabaseHas('assets', $this->payload);
    $this->assertDatabaseCount('assets', 1);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Record created successfully');
    // return $response->getData();

});

test('error when wrong company id is provided', function () {
    $response = $this->post("http://localhost:80/api/v2/companies/wrong-company-id/assets", $this->payload);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
    $this->assertDatabaseMissing('assets', $this->payload);
    $this->assertDatabaseCount('assets', 0);
});

test('error when payload is empty', function () {
    $response = $this->post("http://localhost:80/api/v2/companies/{$this->company->id}/assets", []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    expect($response->getData()->success)->toBeFalse();
    expect($response->getData()->message)->toBe('Validation error');
    $this->assertDatabaseCount('assets', 0);
});
