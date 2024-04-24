<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Models\ConvertQueuedVideo\ConvertQueuedVideo;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(ConvertQueuedVideo::class, static function (Faker $faker) {
    return [
        'video_id'      => fn() => factory(RemoteVideo::class)->create(),
        'tenant_id'      => fn() => factory(Tenant::class)->create(),
        'is_converting'     => false,
        'failed_exception' => null,
        'converted_at' => null,
        'failed_at' => null
    ];
});
