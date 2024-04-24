<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Video\Subtitle;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Subtitle::class, static function (Faker $faker) {
    return [
        'url'        => $url = $faker->imageUrl(),
        'path'       => parse_url($url, PHP_URL_PATH),
        'title'      => $faker->word(),
        'file_name'  => sprintf('%s.vtt', Uuid::uuid4()->toString()),
        'size'       => $faker->randomNumber(),
        'extension'  => 'vtt',
        'is_active'  => $faker->boolean,
        'language'   => $faker->languageCode,
        'video_id'   => fn() => factory(Video::class)->create(),
        'created_by' => fn() => factory(User::class)->create(),
    ];
});
