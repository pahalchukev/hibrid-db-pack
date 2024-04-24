<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Subscription\SubscriptionSubscriber;
use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Tenant\ApiClient;

$factory->define(SubscriptionSubscriber::class, function (Faker $faker) {
    return [
        'subscriber_id' => $faker->numberBetween(1, 1000000),
        'subscription_id' => fn() => factory(Subscription::class)->create(),
        'price' => $faker->randomFloat(2, 1, 9999),
        'type' => $faker->randomElement([SubscriptionSubscriber::TVOD_TYPE, Subscription::SVOD_TYPE]),
        'tenant_id' => fn() => factory(Tenant::class)->create(),
        'api_client_id' => fn() => factory(ApiClient::class)->create(),
    ];
});
