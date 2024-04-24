<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\User\UserInviteToken;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(UserInviteToken::class, static function (Faker $faker) {
    return [
        'token'   => Str::uuid(),
        'user_id' => static fn() => factory(User::class)->create(),
    ];
});
