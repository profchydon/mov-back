<?php

use App\Domains\Constant\OfficeConstant;
use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Enum\User\UserInvitationStatusEnum;
use App\Domains\Enum\User\UserStageEnum;
use App\Models\Company;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Http\Response;
use Tests\TestCase;

beforeEach(function () {
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
    $this->user->userCompanies()->create([
        UserCompanyConstant::COMPANY_ID => $this->company->id,
        UserCompanyConstant::TENANT_ID => $this->company->tenant_id,
        UserCompanyConstant::OFFICE_ID => $this->office->id,
    ]);
});

test('invite user', function () {
    $data = [
        ['email' => fake()->safeEmail(), 'role_id' => $this->role->id],
        ['email' => fake()->safeEmail(), 'role_id' => $this->role->id],
    ];

    $payload = [
        'data' => $data,
    ];

    $response = $this->actingAs($this->user)
        ->postJson(TestCase::fullLink("/companies/{$this->company->id}/invitees"), $payload);

    $response->assertCreated();

    foreach ($data as  $value) {
        $this->assertDatabaseHas('user_invitations', $value);
    }

    $this->assertDatabaseCount('user_invitations', 2);
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->message)->toBe('You have successfully invited users');
});

test('fetch user invitation', function () {
    $invitation = UserInvitation::factory()->create([
        UserInvitationConstant::ROLE_ID => $this->role->id,
        UserInvitationConstant::COMPANY_ID => $this->company,
        UserInvitationConstant::INVITED_BY => $this->user,
    ]);

    $response = $this->get(TestCase::fullLink("/users/invitation/{$invitation->code}"));
    $response->assertOk();
    expect($response->getData()->success)->toBeTrue();
    expect($response->getData()->data->status)->toBe(UserInvitationStatusEnum::PENDING->value);
    expect($invitation)->toBeInstanceOf(UserInvitation::class);
    // expect($response->getData()->data)->toContain($invitation);
});

test('error when email provider is different from invited email', function () {
    $invitation = UserInvitation::factory()->create([
        UserInvitationConstant::ROLE_ID => $this->role->id,
        UserInvitationConstant::COMPANY_ID => $this->company,
        UserInvitationConstant::INVITED_BY => $this->user,
    ]);

    $payload = [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => fake()->safeEmail(),
        'password' => fake()->password(),
        'job_title' => fake()->jobTitle(),
    ];

    $response = $this->postJson(TestCase::fullLink("/users/invitation/{$invitation->code}"), $payload);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    expect($response->getData()->success)->toBeFalse();
    expect($response->getData()->message)->toBe('Validation error');
});


// test('accept invitation', function () {

//     $invitation = UserInvitation::factory()->create([
//         UserInvitationConstant::ROLE_ID => $this->role->id,
//         UserInvitationConstant::COMPANY_ID => $this->company,
//         UserInvitationConstant::INVITED_BY => $this->user,
//     ]);

//     $payload = [
//         'first_name' => fake()->firstName(),
//         'last_name' => fake()->lastName(),
//         'email' => $invitation->email,
//         'password' => "*Rayda22349#",
//         'job_title' => fake()->jobTitle(),
//     ];

//     $response = $this->postJson(TestCase::fullLink("/users/invitation/{$invitation->code}"), $payload);
//     @dump($response);
//     $response->assertOk();
//     expect($response->getData()->success)->toBeTrue();

// $initationAfterUpdate = $invitation->fresh();
// expect($initationAfterUpdate->status)->toBe(UserInvitationStatusEnum::ACCEPTED->value);

// });
