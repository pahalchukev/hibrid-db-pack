<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\ApiClient;
use \HibridVod\Database\Models\Subscriber\Subscriber;
use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Subscriber\SubscriberSubscription;

$factory->define(SubscriberSubscription::class, function (Faker $faker) {
    return [
        'subscriber_id' => fn() => factory(Subscriber::class)->create(),
        'subscription_id' => fn() => factory(Subscription::class)->create(),
        'price' => $faker->randomFloat(2, 1, 999),
        'type' => $faker->randomElement([Subscription::TVOD_TYPE, Subscription::SVOD_TYPE]),
        'expiring_at' => $faker->dateTime,
        'expired_at' => $faker->dateTime
    ];
});
