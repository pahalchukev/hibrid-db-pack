<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\Permission;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Permission::class, static function (Faker $faker) {
    return [
        'name'       => $faker->word,
        'group'      => $faker->word,
        'guard_name' => $faker->word,
    ];
});
