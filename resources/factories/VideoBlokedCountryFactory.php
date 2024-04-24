<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Video\VideoBlockedCountry;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(VideoBlockedCountry::class, static function (Faker $faker) {
    return [
        'video_id'   => fn() => factory(Video::class)->create(),
        'country_code' => $faker->randomElement(['US', 'AU', 'GI', 'UA'])
    ];
});
