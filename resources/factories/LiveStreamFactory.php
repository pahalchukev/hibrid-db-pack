<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Stream\LiveStream;

$factory->define(LiveStream::class, static function (Faker $faker) {
    return [
        'title' => $faker->name,
        'dvr_server_id' => $faker->uuid,
        'dvr_server_ip' => $faker->ipv4,
        'dvr_id' => $faker->uuid,
        'dvr_options' => json_encode(['application' => 'hibrid', 'stream' => 'sample_1080p']),
        'nimble_secret' => $faker->password,
        'tenant_id' => fn() => factory(Tenant::class)->create(),
        'is_catchup' => true,
        'max_editing_duration' => 200,
        'last_recording_time' => $faker->dateTime
    ];
});
