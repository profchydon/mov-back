<?php

namespace Tests\Feature\V2\Departments;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Tests\TestCase;

beforeEach(function () {
    $this->artisan('db:seed --class=CountrySeeder');
    $this->artisan('db:seed --class=CurrencySeeder');
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('auth_token')->plainTextToken;
    $this->useDatabaseTransactions = true;
});

it('can create department area with valid data', function () {
    $company = Company::factory()->create();

    $departmentCount = Department::count();
    $this->assertDatabaseCount('departments', $departmentCount);

    $payload = [
        'name' => 'Jenkins',
    ];

    $response = $this->withToken($this->token)->postJson(TestCase::fullLink("/companies/$company->id/departments"), $payload);
    $response->assertCreated();

    $this->assertDatabaseCount('departments', $departmentCount + 1);
    $this->assertDatabaseHas('departments', $payload);
});

it('can edit department with valid data', function () {
    $department = Department::factory()->create();

    $payload = [
        'name' => 'new name',
    ];

    $response = $this->withToken($this->token)->putJson(TestCase::fullLink("/companies/$department->company_id/departments/{$department->id}"), $payload);
    $response->assertOk();

    $departmentAfterUpdate = $department->fresh();

    $this->assertEquals($department->id, $departmentAfterUpdate->id);
    $this->assertNotEquals($department->name, $departmentAfterUpdate->name);
});

it('can delete department', function () {
    Department::factory(3)->create();
    $department = Department::factory()->create();

    $departmentCount = Department::count();
    $this->assertDatabaseCount('departments', $departmentCount);


    $response = $this->withToken($this->token)->deleteJson(TestCase::fullLink("/companies/$department->company_id/departments/{$department->id}"));
    $response->assertNoContent();
    $this->assertLessThan($departmentCount, Department::count());
});
