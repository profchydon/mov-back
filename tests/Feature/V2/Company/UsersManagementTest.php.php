<?php

use App\Domains\Constant\OfficeConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Office;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Http\Response;
use Tests\TestCase;

beforeEach(function () {
    $this->seed();
    $this->artisan('db:seed --class=RoleSeeder');
    $this->role = Role::inRandomOrder()->first();
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        UserConstant::TENANT_ID => $this->company->tenant_id,
        UserConstant::STAGE => UserStageEnum::COMPLETED,
    ]);
    $this->office = Office::factory()->create([
        OfficeConstant::TENANT_ID => $this->company->tenant_id,
        OfficeConstant::COMPANY_ID => $this->company->id,
    ]);
    $this->token = $this->user->createToken('auth_token')->plainTextToken;
    $this->department = Department::factory()->create();
    $this->useDatabaseTransactions = true;
});

test('can invite a new user', function () {
    $team = Team::factory()->create();

    $payload = [
        'name' => fake()->name(),
        'email' => fake()->safeEmail(),
        'job_title' => fake()->jobTitle(),
        'employment_type' => fake()->word(),
        'role_id' => $this->role->id,
        'office_id' => $this->office->id,
        'department_id' => $this->department->id,
        'team' => $team->id,
    ];

    $response = $this->withToken($this->token)
        ->postJson(TestCase::fullLink("/companies/{$this->company->id}/users"), $payload);

    $response->assertCreated();

    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Record created successfully');
});

test('can fetch users', function () {
    $response = $this->withToken($this->token)->get(TestCase::fullLink("/companies/{$this->company->id}/users"));

    $response->assertStatus(Response::HTTP_OK);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Records fetched successfully');
});

test('can delete a user', function () {
    $user = UserInvitation::factory()->create();

    $response = $this->withToken($this->token)->delete(TestCase::fullLink("/companies/{$this->company->id}/users/{$user->id}"));

    $response->assertStatus(Response::HTTP_OK);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('Record successfully deleted');

    $this->assertDatabaseCount('user_invitations', 0);
});
