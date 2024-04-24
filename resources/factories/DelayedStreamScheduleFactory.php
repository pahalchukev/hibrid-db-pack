<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Stream\LiveStream;
use HibridVod\Database\Models\Stream\DelayedStream;
use HibridVod\Database\Models\Stream\DelayedStreamSchedule;

$factory->define(DelayedStreamSchedule::class, static function (Faker $faker) {
    return [
        'stream_id'         => fn() => factory(LiveStream::class)->create(),
        'delayed_stream_id' => fn() => factory(DelayedStream::class)->create(),
        'command'           => $faker->name,
        'execute_at'        => $faker->dateTime,
        'executed_at'       => $faker->dateTime,
    ];
});
