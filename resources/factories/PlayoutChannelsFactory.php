<?php

use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Tenant\Tenant;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\HibridVod\Database\Models\Playout\PlayoutChannels::class, static function (Faker $faker) {
    return [
        'instance_id'          => fn() => factory(\HibridVod\Database\Models\Playout\Playout::class)->create(),
        'channel_id' => fn() => factory(Channel::class)->create(),
        'tenant_id' => fn() => factory(Tenant::class)->create()
    ];
});
