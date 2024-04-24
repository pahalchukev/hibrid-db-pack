<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Playlist\Playlist;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Playlist::class, static function (Faker $faker) {
    return [
        'title'       => $faker->name,
        'description' => $faker->realText(),
        'thumbnail'   => $faker->imageUrl(),
        'is_active'   => $faker->boolean(),
        'created_by'  => fn() => factory(User::class)->create(),
        'tenant_id'   => fn() => factory(Tenant::class)->create(),
    ];
});
