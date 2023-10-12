<?php

namespace Tests\Feature\V2\Company;

use App\Models\Company;
use App\Models\Office;
use Illuminate\Http\Response;
use Tests\TestCase;

beforeEach(function () {
    $this->seed();
    $this->useDatabaseTransactions = true;
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

    $company = Company::factory()->create();

    $response = $this->postJson(TestCase::fullLink("/companies/{$company->id}/offices"), $payload);
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

    $company = Company::factory()->create();

    $response = $this->postJson(TestCase::fullLink("/companies/{$company->id}/offices"), $payload);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJson([
        'errors' => [
            'country' => ['The selected country is invalid.'],
            'state' => ['The state not match a valid country name'],
        ],
    ]);
});

it('can edit office with valid data', function () {
    $company = Company::factory()->create();

    $office = Office::factory([
        'tenant_id' => $company->tenant_id,
    ])->recycle($company)->create();

    $payload = [
        'name' => 'Loki Town',
    ];

    $response = $this->putJson(TestCase::fullLink("/companies/{$company->id}/offices/{$office->id}"), $payload);
    $response->assertOk();

    $officeAfterUpdate = $office->fresh();

    $this->assertEquals($office->id, $officeAfterUpdate->id);
    $this->assertNotEquals($office->name, $officeAfterUpdate->name);
});

it('deletes office', function () {
    $company = Company::factory()->create();

    $office = Office::factory([
        'tenant_id' => $company->tenant_id,
    ])->recycle($company)->create();

    $officeCount = Office::count();
    $this->assertDatabaseCount('offices', $officeCount);

    $response = $this->deleteJson(TestCase::fullLink("/companies/{$company->id}/offices/{$office->id}"));
    $response->assertNoContent();
    $this->assertLessThan($officeCount, Office::count());
});
