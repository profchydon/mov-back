<?php

namespace Tests\Feature\V2\Company;

use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Models\Company;
use App\Models\Office;
use App\Models\OfficeArea;
use App\Models\User;
use App\Models\UserCompany;
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
        'x-company-id' => $this->company->id,
    ]);
});

it('can create office area with valid data', function () {
    $office = Office::factory([
        'tenant_id' => $this->company->tenant_id,
    ])->recycle($this->company)->create();



    $officeCount = OfficeArea::count();
    $this->assertDatabaseCount('office_areas', $officeCount);
    $payload = [
        'name' => 'Jenkins',
    ];

    $response = $this->postJson(TestCase::fullLink("/offices/{$office->id}/areas"), $payload);
    $response->assertCreated();

    $this->assertDatabaseCount('office_areas', $officeCount + 1);
    $this->assertDatabaseHas('office_areas', $payload);
});



it('can edit office with valid data', function () {
    $office = Office::factory([
        'tenant_id' => $this->company->tenant_id,
    ])->recycle($this->company)->create();

    $area = $office->areas()->create([
        'name' => 'Top Floor Corner',
        'tenant_id' => $this->company->tenant_id,
        'company_id' => $this->company->id,
    ]);

    $payload = [
        'name' => 'Floor Corner',
    ];

    $response = $this->putJson(TestCase::fullLink("/offices/{$office->id}/areas/{$area->id}"), $payload);
    $response->assertOk();

    $areaAfterUpdate = $area->fresh();

    $this->assertEquals($area->id, $areaAfterUpdate->id);
    $this->assertNotEquals($area->name, $areaAfterUpdate->name);
});

it('deletes office', function () {
    $office = Office::factory([
        'tenant_id' => $this->company->tenant_id,
    ])->recycle($this->company)->create();

    $officeCount = Office::count();
    $this->assertDatabaseCount('offices', $officeCount);

    $area = $office->areas()->create([
        'name' => 'Top Floor Corner',
        'tenant_id' => $this->company->tenant_id,
        'company_id' => $this->company->id,
    ]);

    $response = $this->deleteJson(TestCase::fullLink("/offices/{$office->id}/areas/{$area->id}"));
    $response->assertNoContent();
    $this->assertLessThan($officeCount, OfficeArea::count());
});
