<?php

namespace Tests\Feature\V2\Company;

use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Models\Company;
use App\Models\Office;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

beforeEach(function () {
    $this->seed();
    $this->useDatabaseTransactions = true;
    $this->company = Company::factory()->create();
    $user = User::factory()->create([
        UserConstant::TENANT_ID => $this->company->tenant_id,
        UserConstant::STAGE => UserStageEnum::COMPLETED,
    ]);
    $token = $user->createToken('auth_token')->plainTextToken;

    UserCompany::create([
        'user_id' => $user->id,
        'tenant_id' => $this->company->tenant_id,
        'company_id' => $this->company->id,
    ]);

    $this->withHeaders([
        'Authorization' => "Bearer {$token}",
        'Accept' => 'application/json',
        'x-company-id' => $this->company->id
    ]);
});

it('can create office with valid data', function () {
    $payload = [
        'name' => 'Loki Town',
        'street_address' => fake()->streetAddress(),
        'country' => 'Nigeria',
        'currency_code' => 'NGN',
        'state' => 'Lagos',
        'latitude' => 30.72,
        'longitude' => -18.78,
    ];

    $officeCount = Office::count();
    $this->assertDatabaseCount('offices', $officeCount);


    $response = $this->postJson(TestCase::fullLink("/companies/{$this->company->id}/offices"), $payload);

    Log::info($response->getContent());
    $response->assertCreated();

    $this->assertDatabaseCount('offices', $officeCount + 1);
    $this->assertDatabaseHas('offices', $payload);
});

it('does not create office with invalid data', function () {
    $payload = [
        'name' => 'Loki Town',
        'street_address' => fake()->streetAddress(),
        'country' => 'Lekki',
        'currency_code' => 'NGN',
        'state' => 'Farm City',
        'latitude' => 30.72,
        'longitude' => -18.78,
    ];

    $officeCount = Office::count();
    $this->assertDatabaseCount('offices', $officeCount);

    $response = $this->postJson(TestCase::fullLink("/companies/{$this->company->id}/offices"), $payload);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJson([
        'errors' => [
            'country' => ['The selected country is invalid.'],
            'state' => ['The state not match a valid country name'],
        ],
    ]);
});

it('can edit office with valid data', function () {

    $office = Office::factory([
        'tenant_id' => $this->company->tenant_id,
    ])->recycle($this->company)->create();

    $payload = [
        'name' => 'Loki Town',
    ];

    $response = $this->putJson(TestCase::fullLink("/companies/{$this->company->id}/offices/{$office->id}"), $payload);
    $response->assertOk();

    $officeAfterUpdate = $office->fresh();

    $this->assertEquals($office->id, $officeAfterUpdate->id);
    $this->assertNotEquals($office->name, $officeAfterUpdate->name);
});

it('deletes office', function () {

    $office = Office::factory([
        'tenant_id' => $this->company->tenant_id,
    ])->recycle($this->company)->create();

    $officeCount = Office::count();
    $this->assertDatabaseCount('offices', $officeCount);

    $response = $this->deleteJson(TestCase::fullLink("/companies/{$this->company->id}/offices/{$office->id}"));
    $response->assertNoContent();
    $this->assertLessThan($officeCount, Office::count());
});
