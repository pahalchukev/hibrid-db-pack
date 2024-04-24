<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Subscription\Subscription;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'title'      => $faker->words(5, true),
        'time'       => $faker->randomNumber(2),
        'price'      => $faker->randomFloat(2, 1, 9999),
        'type'       => $faker->randomElement([Subscription::TVOD_TYPE, Subscription::SVOD_TYPE]),
        'created_by' => fn() => factory(User::class)->create(),
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});
