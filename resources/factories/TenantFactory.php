<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tenant::class, static function (Faker $faker) {
    return [
        'name'                => $name = $faker->name,
        'alias'               => \Illuminate\Support\Str::slug($name),
        'contact_information' => ["name" => "Tim", "phone" => "+42038*******"],
        'playout_seats'                => $faker->randomDigit(),
    ];
});
