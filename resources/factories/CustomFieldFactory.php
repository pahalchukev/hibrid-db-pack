<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\CustomField\CustomField;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CustomField::class, static function (Faker $faker) {
    return [
        'tenant_id' => fn() => factory(Tenant::class)->create(),
        'type' => 'string',
        'is_active' => $faker->boolean(),
        'label' => $faker->words(1, true),
        'options' => null,
        'entity_type' => 'video'
    ];
});
