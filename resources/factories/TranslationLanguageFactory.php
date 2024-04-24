<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Translation\TranslationLanguage;

$factory->define(TranslationLanguage::class, static function (Faker $faker) {
    return [
        'lang' => $faker->languageCode(),
        'tenant_id' => fn() => factory(Tenant::class)->create()
    ];
});
