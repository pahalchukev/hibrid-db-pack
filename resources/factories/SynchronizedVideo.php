<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Models\RemoteSync\Connection;
use HibridVod\Database\Models\RemoteSync\SynchronizedVideo;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(SynchronizedVideo::class, static function (Faker $faker) {
    return [
        'extension' => $ext = $faker->fileExtension,
        'path' => $path = '/some/local/path',
        'size' => $faker->randomNumber(),
        'file_name' => $name = $faker->slug() . $ext,
        'full_path' => $path . $name,
        'last_modified' => $faker->dateTime,
        'reference_id' => Uuid::uuid4()->toString(),
        'connection_id' => static fn() => factory(Connection::class)->create(),
        'tenant_id' => static fn() => factory(Tenant::class)->create(),
        'remote_video_id' => static fn() => factory(RemoteVideo::class)->create()
        //'video_id'      => static fn() => factory(Connection::class)->create(),
    ];
});
