<?php

use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;

beforeEach(function () {
    $this->artisan('db:seed --class=CountrySeeder');
    $this->artisan('db:seed --class=CurrencySeeder');
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
        'x-company-id' => $this->company->id,
    ]);
});

test('it can create maintenance log', function () {
    $user = \App\Models\User::factory()->create([
        \App\Domains\Constant\UserConstant::TENANT_ID => $this->company->tenant_id,
        \App\Domains\Constant\UserConstant::STAGE => \App\Domains\Enum\User\UserStageEnum::COMPLETED,
    ]);

    $vendor = \App\Models\Vendor::create([
        \App\Domains\Constant\UserConstant::TENANT_ID => $this->company->tenant_id,
        'company_id' => $this->company->id,
        'name' => fake()->name(),
        'email' => fake()->safeEmail(),
        'phone_number' => fake()->phoneNumber(),
        'address' => fake()->address()
    ]);

    $assets = \App\Models\Asset::factory(5)->create([
        'tenant_id' => $this->company->tenant_id,
        'company_id' => $this->company->id,
        'status' => \App\Domains\Enum\Asset\AssetStatusEnum::AVAILABLE,
    ]);


    $payload = [
        'reason' => 'quick brown fox',
        'receiver_id' => $vendor->id,
        'scheduled_date' => now()->format('Y-m-d'),
        'return_date' => now()->addMonth()->format('Y-m-d'),
        'comment' => fake()->sentence(),
        'assets' => $assets->pluck('id'),
    ];

    $response = $this->postJson(\Tests\TestCase::fullLink("/companies/{$this->company->id}/asset-maintenances"), $payload);
    $response->assertCreated();
});

test('it can get maintenance log', function () {
    $this->company = \App\Models\Company::factory()->create();
    $user = \App\Models\User::factory()->create([
        \App\Domains\Constant\UserConstant::TENANT_ID => $this->company->tenant_id,
        \App\Domains\Constant\UserConstant::STAGE => \App\Domains\Enum\User\UserStageEnum::COMPLETED,
    ]);

    $assets = \App\Models\Asset::factory(5)->create([
        'tenant_id' => $this->company->tenant_id,
        'company_id' => $this->company->id,
        'status' => \App\Domains\Enum\Asset\AssetStatusEnum::AVAILABLE,
    ]);

    $payload = [
        'reason' => 'quick brown fox',
        'receiver_id' => $user->id,
        'scheduled_date' => now()->format('Y-m-d'),
        'return_date' => now()->addMonth()->format('Y-m-d'),
        'comment' => fake()->sentence(),
        'assets' => $assets->pluck('id'),
    ];

    $this->postJson(\Tests\TestCase::fullLink("/companies/{$this->company->id}/asset-maintenances"), $payload);
    $response = $this->getJson(\Tests\TestCase::fullLink("/companies/{$this->company->id}/asset-maintenances"), $payload);
    $response->assertOk();
});
