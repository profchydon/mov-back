<?php

use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Asset\AssetAcquisitionTypeEnum;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Models\AssetType;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Office;
use App\Models\User;
use App\Repositories\AssetRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

beforeEach(function () {
    $this->artisan('db:seed --class=CountrySeeder');
    $this->artisan('db:seed --class=CurrencySeeder');
    $this->currency = Currency::inRandomOrder()->first();
    $this->make = ['Apple', 'Samsung'];
    $this->model = ['Iphone', 'Galaxy'];
    $this->assetRepository = new AssetRepository();
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('auth_token')->plainTextToken;
    $this->asset_type = AssetType::factory()->create();
    $this->office = Office::factory()->create([
        OfficeConstant::TENANT_ID => $this->company->tenant_id,
        OfficeConstant::COMPANY_ID => $this->company->id,
    ]);

    $this->payload = [
        AssetConstant::TENANT_ID => $this->company->tenant_id,
        AssetConstant::COMPANY_ID => $this->company->id,
        AssetConstant::TYPE_ID => $this->asset_type->id,
        AssetConstant::MAKE => $this->make[array_rand($this->make)],
        AssetConstant::MODEL => $this->model[array_rand($this->model)],
        AssetConstant::SERIAL_NUMBER => Str::random(10),
        AssetConstant::OFFICE_ID => $this->office->id,
        AssetConstant::PURCHASE_PRICE => '300000.00',
        AssetConstant::CURRENCY => $this->currency->code,
        AssetConstant::ADDED_AT => now(),
        AssetConstant::STATUS => AssetStatusEnum::AVAILABLE->value,
    ];
});

test('create single asset', function () {
    $response = $this->withToken($this->token)->postJson(TestCase::fullLink("/companies/{$this->company->id}/assets"), $this->payload);
    $response->assertCreated();
    $this->assertDatabaseCount('assets', 1);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Record created successfully');
});

test('error when wrong company id is provided', function () {
    $response = $this->withToken($this->token)->postJson(TestCase::fullLink('/companies/wrong-company-id/assets'), $this->payload);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
    $this->assertDatabaseMissing('assets', $this->payload);
    $this->assertDatabaseCount('assets', 0);
});

test('error when payload is empty', function () {
    $response = $this->withToken($this->token)->postJson(TestCase::fullLink("/companies/{$this->company->id}/assets"), []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    expect($response->getData()->success)->toBeFalse();
    expect($response->getData()->message)->toBe('Validation error');
    $this->assertDatabaseCount('assets', 0);
});


test('get assets', function () {
    $response = $this->withToken($this->token)->get(TestCase::fullLink("/companies/{$this->company->id}/assets"));
    $response->assertStatus(Response::HTTP_OK);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Records fetched successfully');
});

test('get asset details', function () {
    $asset = $this->company->assets()->create($this->payload);
    $response = $this->withToken($this->token)->get(TestCase::fullLink("/companies/{$this->company->id}/assets/{$asset->id}"));
    $response->assertStatus(Response::HTTP_OK);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Records fetched successfully');
});

test('update asset details', function () {
    $asset = $this->company->assets()->create($this->payload);

    $updatePayload = [
        'acquisitionType' => AssetAcquisitionTypeEnum::BRAND_NEW->value,
    ];

    $response = $this->patch(TestCase::fullLink("/companies/{$this->company->id}/assets/{$asset->id}?type=details"), $updatePayload);

    $response->assertStatus(Response::HTTP_OK);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Asset has been updated');
});
