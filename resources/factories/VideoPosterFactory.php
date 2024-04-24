<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Video\Poster;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Poster::class, static function (Faker $faker) {
    return [
        'url' => $url = $faker->imageUrl(),
        'path' => parse_url($url, PHP_URL_PATH),
        'dimensions' => '16-9',
        'video_id' => fn() => factory(Video::class)->create(),
    ];
});
