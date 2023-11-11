<?php

beforeEach(function () {
    $this->seed();
    $this->useDatabaseTransactions = true;
});

test('it can create maintenance log', function(){
    $company = \App\Models\Company::factory()->create();
    $user = \App\Models\User::factory()->create([
        \App\Domains\Constant\UserConstant::TENANT_ID => $company->tenant_id,
        \App\Domains\Constant\UserConstant::STAGE => \App\Domains\Enum\User\UserStageEnum::COMPLETED,
    ]);

    $assets = \App\Models\Asset::factory(5)->create([
        'tenant_id' => $company->tenant_id,
        'company_id' => $company->id,
        'status' => \App\Domains\Enum\Asset\AssetStatusEnum::AVAILABLE
    ]);

    $payload = [
        'reason' => "quick brown fox",
        'receiver_id' => $user->id,
        'scheduled_date' => now()->format('Y-m-d'),
        'return_date' => now()->addMonth()->format('Y-m-d'),
        'comment' => fake()->sentence(),
        'assets' => $assets->pluck('id'),
    ];

    $response = $this->postJson(\Tests\TestCase::fullLink('/asset-maintenances'), $payload);
    $response->assertCreated();
});

test('it can get maintenance log', function(){
    $company = \App\Models\Company::factory()->create();
    $user = \App\Models\User::factory()->create([
        \App\Domains\Constant\UserConstant::TENANT_ID => $company->tenant_id,
        \App\Domains\Constant\UserConstant::STAGE => \App\Domains\Enum\User\UserStageEnum::COMPLETED,
    ]);

    $assets = \App\Models\Asset::factory(5)->create([
        'tenant_id' => $company->tenant_id,
        'company_id' => $company->id,
        'status' => \App\Domains\Enum\Asset\AssetStatusEnum::AVAILABLE
    ]);

    $payload = [
        'reason' => "quick brown fox",
        'receiver_id' => $user->id,
        'scheduled_date' => now()->format('Y-m-d'),
        'return_date' => now()->addMonth()->format('Y-m-d'),
        'comment' => fake()->sentence(),
        'assets' => $assets->pluck('id'),
    ];

    $this->postJson(\Tests\TestCase::fullLink('/asset-maintenances'), $payload);
    $response = $this->getJson(\Tests\TestCase::fullLink("/companies/{$company->id}/asset-maintenances"), $payload);
    $response->assertOk();
});
