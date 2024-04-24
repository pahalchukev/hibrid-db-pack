<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Stream\LiveStream;
use HibridVod\Database\Models\Stream\LiveStreamSeat;
use HibridVod\Database\Models\Video\RemoteVideo;

$factory->define(LiveStreamSeat::class, static function (Faker $faker) {
    return [
        'stream_id' => fn() => factory(LiveStream::class)->create(),
        'created_by' => fn() => factory(User::class)->create(),
        'tenant_id' => fn() => factory(Tenant::class)->create(),
        'is_active' => false,
        'start_timestamp' => '123123123123',
        'end_timestamp' => '123123123123',
        'remote_video_id' => fn() => factory(RemoteVideo::class)->create()
    ];
});
