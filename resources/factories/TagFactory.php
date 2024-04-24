<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Tag::class, static function (Faker $faker) {
    return [
        'title'      => $faker->name,
        'color'      => $faker->hexColor,
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});
