<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\User\Role;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, static function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'username'   => $faker->userName,
        'email'      => $faker->email,
        'password'   => 'password',
        'tenant_id'  => static fn() => factory(Tenant::class)->create(),
        'role_id'    => static fn() => factory(Role::class)->create(),
    ];
});
