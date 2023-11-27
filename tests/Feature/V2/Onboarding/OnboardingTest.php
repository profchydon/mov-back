<?php

namespace Tests\Feature\V2\Onboarding;

use App\Domains\Enum\User\UserStageEnum;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

beforeEach(function () {
    $this->artisan('db:seed --class=PermissionSeeder');
    $this->artisan('db:seed --class=RoleSeeder');
});


//it('can create a company', function () {
//    $email = fake()->safeEmail();
//    $phone = fake()->phoneNumber();
//
//    $data = [
//        'company' => [
//            'email' => $email,
//            'phone' => $phone,
//        ],
//        'user' => [
//            'first_name' => fake()->firstName(),
//            'last_name' => fake()->lastName(),
//            'email' => $email,
//            'phone' => $phone,
//            'password' => '*Rayda38349#',
//        ],
//    ];
//
//    $response = $this->postJson(TestCase::fullLink('/companies'), $data);
//
//    $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
//        'success',
//        'message',
//        'data' => [
//            'user',
//            'company',
//        ],
//    ]);
//
//    $this->assertDatabaseHas('companies', $data['company']);
//});

// it('can update company details', function () {
//     $email = fake()->email;
//     $phone = fake()->phoneNumber();

//     $data = [
//         'company' => [
//             'email' => $email,
//             'phone' => $phone,
//         ],
//         'user' => [
//             'first_name' => fake()->firstName(),
//             'last_name' => fake()->lastName(),
//             'email' => $email,
//             'phone' => $phone,
//             'password' => fake()->password(),
//         ],
//     ];

//     $response = $this->postJson(TestCase::fullLink("/companies"), $data);
//     $companyId = $response['data']['company']['id'];
//     $userId = $response['data']['user']['id'];

//     User::find($userId)->update(['stage' => UserStageEnum::COMPANY_DETAILS->value]);

//     $data = [
//         'name' => fake()->company(),
//         'size' => 'Just me',
//         'industry' => 'IT',
//         'address' => fake()->address(),
//     ];

//     $response = $this->postJson(route('companies.update', ['company' => $companyId]), $data);

//     $response->assertOk()->assertJsonStructure([
//         'success',
//         'message',
//         'data',
//     ]);
// });

// it('can create company subscription', function () {
//     $email = fake()->email;
//     $phone = fake()->phoneNumber();

//     $data = [
//         'company' => [
//             'email' => $email,
//             'phone' => $phone,
//         ],
//         'user' => [
//             'first_name' => fake()->firstName(),
//             'last_name' => fake()->lastName(),
//             'email' => $email,
//             'phone' => $phone,
//             'password' => fake()->password(),
//         ],
//     ];

//     $response = $this->postJson(route('companies.create'), $data);
//     $companyId = $response['data']['company']['id'];
//     $userId = $response['data']['user']['id'];

//     User::find($userId)->update(['stage' => UserStageEnum::SUBSCRIPTION_PLAN->value]);
//     $plan = Plan::first();

//     $data = [
//         'plan_id' => $plan->id,
//         'billing_cycle' => 'MONTHLY',
//         'currency' => 'NGN',
//     ];

//     $response = $this->postJson(route('create.company.subscription', ['company' => $companyId]), $data);

//     $response->assertOk()->assertJsonStructure([
//         'success',
//         'message',
//         'data',
//     ]);
// });
