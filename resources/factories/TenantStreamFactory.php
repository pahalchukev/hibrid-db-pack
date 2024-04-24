<?php

use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\TenantStream\TenantStream;
use HibridVod\Database\Models\Player\Player;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(TenantStream::class, static function (Faker $faker) {
    return [
        'tenant_id'   => fn() => factory(Tenant::class)->create(), 
        'created_by'  => fn() => factory(User::class)->create(),
        'title' => $faker->name,
        'title_trans' => $faker->name, // ?
        'description' => $faker->realText(),
        'description_trans' => $faker->realText(), // ?
        'channel_title' => $faker->name,
        'channel_logo' => $faker->imageUrl(),
        'origin_server_url' => $faker->url('http'),
        'rtmp_source' => $faker->url('rtmp'),
        'cdn_cname' => $faker->name .'.'. $faker->name .'.'. $faker->name,
        'cdn_client_app' => $faker->name,
        'stream_app' => $faker->name,
        'hls_manifest' => $faker->name .'.m3u8',
        'mpd_manifest' => $faker->name .'.mpd',
        'poster' => $faker->imageUrl(),
        'logo' => $faker->imageUrl(),
        'channel_key' => $faker->name,
        'embed_code' => $faker->realText(), // ?
        'monitoring_url' => $faker->url('http'),
        'preview_url' => $faker->url('http'),
        // 'audio_only' =>  $faker->unique()->numberBetween(0, 1),
        'audio_only' =>  (int) $faker->boolean,
        'info_text' => $faker->realText(),
        'info_title' => $faker->name,
        'preroll_type' => $faker->name,
        'ima_ad_tag' => $faker->realText(),
        'ima_ad_params' => $faker->realText(),
        // 'dai_enabled' => $faker->unique()->numberBetween(0, 1),
        'dai_enabled' =>  (int) $faker->boolean,
        'dai_api_key' => $faker->name,
        'dai_asset_key' => $faker->name,
        // 'with_credentials' => $faker->unique()->numberBetween(0, 1),
        'with_credentials' =>  (int) $faker->boolean,
        'lln_ttl' => $faker->unique()->numberBetween(1, 20),
        'lln_secret' => $faker->name,
        'url_algorithm' => $faker->randomElement(['std', 'lln', 'llnpb']),
        'stream_url' => $faker->url('https'),
        'llhls_url' => $faker->url('https'),
        // 'ga_tracking_enabled' => $faker->unique()->numberBetween(0, 1),
        'ga_tracking_enabled' =>  (int) $faker->boolean,
        'ga_tracking_id' => $faker->name,
        // 'thumbnails_enabled' => $faker->unique()->numberBetween(0, 1),
        'thumbnails_enabled' =>  (int) $faker->boolean,
        'thumbnails_config' => $faker->realText(),
        'player_id'   => fn() => factory(Player::class)->create(),
        'dvr_duration' => $faker->unique()->numberBetween(1, 3600),
        'ssai_params' => $faker->realText(),
        'comments' => $faker->realText()
    ];
});
