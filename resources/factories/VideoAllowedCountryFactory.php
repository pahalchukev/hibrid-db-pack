<?php

use HibridVod\Database\Models\Video\VideoAllowedCountry;
use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Video\Video;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(VideoAllowedCountry::class, static function (Faker $faker) {
    return [
        'video_id'   => fn() => factory(Video::class)->create(),
        'country_code' => $faker->randomElement(['US', 'AU', 'GI', 'UA'])
    ];
});
