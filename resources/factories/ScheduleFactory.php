<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\Channel\Schedule;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Video\Video;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Schedule::class, static function (Faker $faker) {
   return [
       'date' => $faker->date(),
       'channel_id' => fn() => factory(Channel::class)->create(),
       'start_time' => $faker->time(),
       'prime_time'  => $faker->time(),
       "prime_time_fill" => $faker->randomElement(['randomly', 'repeat']),
       "prime_time_overlap" => $faker->randomElement(['forced', 'fallback']),
       "prime_time_filler" => fn() => factory(Video::class)->create(),
       'ad_breaks' => json_encode([
           [
               "hour" => "00:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
           [
               "hour" => "01:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
           [
               "hour" => "02:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
           [
               "hour" => "03:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
           [
               "hour" => "04:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
           [
               "hour" => "05:00",
               "break" => $faker->numberBetween(0, 60),
               "duration" => $faker->randomDigit()
           ],
       ]),
       'intro_id'           => fn() => factory(Video::class)->create(),
       'intro_duration'     => $faker->numberBetween(0,1000),
       'outro_id'           => fn() => factory(Video::class)->create(),
       'outro_duration'     => $faker->numberBetween(0,1000),
       'status'             => $faker->randomElement(['success', 'running', 'error']),
       'message'            => json_encode(['value' => 'Test string']),
       'hls_history'        => json_encode(['value' => 'Test string']),
       'extra'              => json_encode(['value' => 'Test string']),
   ];
});