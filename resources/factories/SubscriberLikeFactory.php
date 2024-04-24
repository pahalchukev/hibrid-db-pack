<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use \HibridVod\Database\Models\Subscriber\Subscriber;
use HibridVod\Database\Models\Subscriber\SubscriberLike;
use HibridVod\Database\Models\Video\Video;

$factory->define(SubscriberLike::class, function (Faker $faker) {
    return [
        'subscriber_id' => fn() => factory(Subscriber::class)->create(),
        'video_id' => fn() => factory(Video::class)->create(),
        'like' => $faker->randomElement([true, false])
    ];
});
