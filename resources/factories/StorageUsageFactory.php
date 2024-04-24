<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\StorageUsage;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(StorageUsage::class, static function (Faker $faker) {
    return [
        'used'      => $faker->numberBetween(1, 999999999),
        'filled_at' => $faker->date(),
        'tenant_id' => fn() => factory(Tenant::class)->create(),
    ];
});
