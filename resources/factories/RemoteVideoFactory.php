<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\ApiClient;
use HibridVod\Database\Models\Video\RemoteVideo;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(RemoteVideo::class, static function (Faker $faker) {
    return [
        'title'         => $faker->word(),
        'description'   => $faker->text,
        'video_url'     => $url = $faker->imageUrl(),
        'webhook_url'   => $url,
        'processed_at'  => $faker->dateTime,
        'reference_id'  => Uuid::uuid4()->toString(),
        'tags_ids'      => fn() => factory(Tag::class)->create()->pluck('id')->toArray(),
        'video_id'      => fn() => factory(Video::class)->create(),
        'tenant_id'     => fn() => factory(Tenant::class)->create(),
        'api_client_id' => fn() => factory(ApiClient::class)->create(),
    ];
});
