<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Cast\CastPoster;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(CastPoster::class, static function (Faker $faker) {
    return [
        'url' => $url = $faker->imageUrl(),
        'path' => parse_url($url, PHP_URL_PATH),
        'dimensions' => '16-9',
        'cast_id' => fn() => factory(Cast::class)->create(),
    ];
});
