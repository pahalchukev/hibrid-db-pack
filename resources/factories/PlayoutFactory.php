<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\HibridVod\Database\Models\Playout\Playout::class, static function (Faker $faker) {
    return [
        'name'          => Uuid::uuid4()->toString(),
        'domain' => 'https://' . Uuid::uuid4()->toString() . '.com',
        'number' => mt_rand(1, 100),
    ];
});
