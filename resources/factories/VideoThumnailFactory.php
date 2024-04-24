<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Video\Thumbnail;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Thumbnail::class, static function (Faker $faker) {
    return [
        'url'        => $url = $faker->imageUrl(),
        'path'       => parse_url($url, PHP_URL_PATH),
        'name'       => sprintf('%s.png', Uuid::uuid4()->toString()),
        'on_second'  => $faker->randomNumber(),
        'source'     => 'auto',
        'is_default' => $faker->boolean,
        'video_id'   => fn() => factory(Video::class)->create(),
    ];
});
