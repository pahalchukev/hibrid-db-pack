<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Player\Player;
use HibridVod\Database\Models\Advertisement\AdvertisementTag;

$factory->define(Player::class, function (Faker $faker) {
    return [
        'title'                => $faker->words(5, true),
        'type'                 => 'videojs',
        'options'              => [],
        'is_default'           => $faker->boolean(),
        'advertisement_tag_id' => fn() => factory(AdvertisementTag::class)->create(),
        'created_by'           => fn() => factory(User::class)->create(),
        'tenant_id'            => fn() => factory(Tenant::class)->create(),

        'domain_status'        => $faker->randomElement(['everywhere-except-were-blocked', 'only-on']),
        'blocked_links'        => [],
        'allowed_links'        => [],
    ];
});
