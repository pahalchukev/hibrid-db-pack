<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\ApiClient;
use \HibridVod\Database\Models\Subscriber\Subscriber;

$factory->define(Subscriber::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->email,
        'phone' => "+42038*******",
        'balance'      => $faker->randomFloat(2, 1, 9999),
        'status'       => true,
        'api_client_id' => fn() => factory(ApiClient::class)->create(),
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});
