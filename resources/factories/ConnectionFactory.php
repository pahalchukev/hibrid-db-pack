<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\RemoteSync\Connection;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Connection::class, static function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'adapter'           => 'ftp',
        'adapter_config'    => [],
        'is_enabled'        => $faker->boolean,
        'is_locked'         => $faker->boolean,
        'fetched_videos'    => $faker->randomNumber(),
        'fetched_size'      => $faker->randomNumber(),
        'last_connected_at' => $faker->dateTime,
        'created_by'        => fn() => factory(User::class)->create(),
        'tenant_id'         => fn() => factory(Tenant::class)->create(),
    ];
});
