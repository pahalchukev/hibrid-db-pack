<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\Role;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Role::class, static function (Faker $faker) {
    return [
        'name'       => $faker->word,
        'alias'      => $faker->word,
        'guard_name' => $faker->word,
        'tenant_id'  => static fn() => factory(Tenant::class)->create(),
    ];
});
