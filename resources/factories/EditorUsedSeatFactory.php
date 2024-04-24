<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\EditorUsedSeat;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(EditorUsedSeat::class, static function (Faker $faker) {
    return [
        'tenant_id' => fn() => factory(Tenant::class)->create(),
        'video_id' => fn() => factory(Video::class)->create(),
        'user_id' => fn() => factory(User::class)->create(),
        'is_active' => true,
        'remote_video_id' => fn() => factory(RemoteVideo::class)->create()
    ];
});
