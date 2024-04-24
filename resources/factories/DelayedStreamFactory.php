<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Stream\LiveStream;
use HibridVod\Database\Models\Stream\DelayedStream;

$factory->define(DelayedStream::class, static function (Faker $faker) {
    return [
        'stream_id'         => fn() => factory(LiveStream::class)->create(),
        'created_by'        => fn() => factory(User::class)->create(),
        'tenant_id'         => fn() => factory(Tenant::class)->create(),
        'title'             => $faker->name,
        'recording_type'    => DelayedStream::ONE_TIME_TYPE,
        'selected_days'     => null,
        'start_at'          => $faker->dateTime,
        'stop_at'           => $faker->dateTime,
    ];
});
