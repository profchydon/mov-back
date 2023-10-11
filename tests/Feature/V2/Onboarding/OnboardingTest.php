<?php

namespace Tests\Feature\V2\Onboarding;

use App\Domains\Enum\User\UserStageEnum;
use App\Models\User;
use Illuminate\Http\Response;

it('can create a company', function () {
    $email = fake()->email;
    $phone = fake()->phoneNumber();

    $data = [
        "company" => [
            "email" => $email,
            "phone" => $phone
        ],
        "user" => [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "email" => $email,
            "phone" => $phone,
            "password" => fake()->password()
        ]
    ];

    $response = $this->postJson(route('companies.create'), $data);

    $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
        'success',
        'message',
        'data' => [
            'user',
            'company'
        ],
    ]);
});

it('can update company details', function () {
    $email = fake()->email;
    $phone = fake()->phoneNumber();

    $data = [
        "company" => [
            "email" => $email,
            "phone" => $phone
        ],
        "user" => [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "email" => $email,
            "phone" => $phone,
            "password" => fake()->password()
        ]
    ];

    $response = $this->postJson(route('companies.create'), $data);
    $companyId = $response['data']['company']['id'];
    $userId = $response['data']['user']['id'];

    User::find($userId)->update(['stage' => UserStageEnum::COMPANY_DETAILS->value]);

    $data = [
        "name" => fake()->company(),
        "size" => "Just me",
        "industry" => "IT",
        "address" => fake()->address(),
    ];

    $response = $this->postJson(route('companies.update', ['company' => $companyId]), $data);

    $response->assertOk()->assertJsonStructure([
        'success',
        'message',
        'data'
    ]);
});