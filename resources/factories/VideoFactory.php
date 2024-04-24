<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Video::class, static function (Faker $faker) {
    return [
        'file_name'          => $file_name = sprintf('%s.%s', Uuid::uuid4()->toString(), $ext = 'mp4'),
        'original_file_name' => $file_name,
        'storage_original_name' => sprintf('%s.%s', Uuid::uuid4()->toString(), 'mp4'),
        'mime'               => 'video/mp4',
        'extension'          => $ext,
        'title'              => $faker->words(5, true),
        'reference_id'       => Uuid::uuid4()->toString(),
        'recorded_at'        => $faker->dateTime,
        'created_by'         => fn() => factory(User::class)->create(),
        'tenant_id'          => fn() => factory(Tenant::class)->create(),
    ];
});

$factory->defineAs(Video::class, 'pending', static function (Faker $faker) {
    return [
        'created_by' => fn() => factory(User::class)->create(),
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});

$factory->defineAs(Video::class, 'converted', static function (Faker $faker) {
    return [
        'created_by' => fn() => factory(User::class)->create(),
        'tenant_id'  => fn() => factory(Tenant::class)->create(),
    ];
});
