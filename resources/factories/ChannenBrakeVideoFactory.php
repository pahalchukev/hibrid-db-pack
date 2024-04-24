<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Pivot\ChannelBreakVideo;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Channel\Channel;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(ChannelBreakVideo::class, static function (Faker $faker) {
    return [
        'channel_id'  => fn() => factory(Channel::class)->create(),
        'video_id'   => fn() => factory(Video::class)->create(),
        'intro_id'   => fn() => factory(Video::class)->create(),
        'outro_id'   => fn() => factory(Video::class)->create()
    ];
});
