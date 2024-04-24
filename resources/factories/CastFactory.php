<?php

use HibridVod\Database\Models\Cast\Cast;
use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Cast::class, static function (Faker $faker) {
    return [
        'reference_id'       => Uuid::uuid4()->toString(),
        'title'              => $faker->words(5, true),
        'description'        => $faker->words(5, true),
        'created_by'         => fn() => factory(User::class)->create(),
        'tenant_id'          => fn() => factory(Tenant::class)->create(),
    ];
});
