<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Advertisement\AdvertisementTag;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(AdvertisementTag::class, static function (Faker $faker) {
    return [
        'tag'        => 'https://google.com',
        'title'      => $faker->words(6, true),
        'type'       => 'vast',
        'created_by' => fn() => factory(User::class)->create(),
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});
