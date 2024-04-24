<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\RemoteSync\SyncAudit;
use HibridVod\Database\Models\RemoteSync\Connection;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(SyncAudit::class, static function (Faker $faker) {
    return [
        'state'         => $faker->boolean,
        'context'       => [],
        'connection_id' => static fn() => factory(Connection::class)->create(),
    ];
});
