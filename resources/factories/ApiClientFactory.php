<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\ApiClient;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(ApiClient::class, static function (Faker $faker) {
    return [
        'name'         => $name = $faker->name,
        'client_id'    => $client_id = Uuid::uuid4()->toString(),
        'access_token' => sha1($client_id),
        'created_by'   => fn() => factory(User::class)->create(),
        'tenant_id'    => fn() => factory(Tenant::class)->create(),
        'is_active'    => true,
    ];
});
