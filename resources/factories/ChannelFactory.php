<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Video\Video;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Channel::class, static function (Faker $faker) {
    return [
        'title'       => $faker->name,
        'description' => $faker->realText(),
        'thumbnail'   => $faker->imageUrl(),
        'prime_time'  => $faker->time(),
        'prime_time_fill' => $faker->randomElement(['randomly', 'repeat']),
        'prime_time_overlap' => $faker->randomElement(['forced', 'fallback']),
        'prime_time_filler' => fn() => factory(Video::class)->create(),
        'is_active'   => $faker->boolean(),
        'is_published'=> $faker->boolean(),
        'created_by'  => fn() => factory(User::class)->create(),
        'tenant_id'   => fn() => factory(Tenant::class)->create(),
        'ad_breaks'   => json_encode([
            "t0000" => [
                "brkFrq"   => 30,
                "duration" => 3
            ],
            "t0100" => [
                "brkFrq"   => 30,
                "duration" => 3
            ],
            "t0200" => [
                "brkFrq"   => 30,
                "duration" => 3
            ],
        ]),
        "video_playout_controls" => json_encode([
            "minDelay"   => 24,
            "recDelay" => 24,
            "maxRepeat" => 1,
            "recRepeatDay" => 1,
            "maxAllowed" => 3,
            "recRepeatMonth" => 4,
        ]),
        'video_dimensions' => $faker->randomElement(['1080', '720', '480'])
    ];
});
