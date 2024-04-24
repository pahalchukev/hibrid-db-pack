<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Category\Category;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Category::class, static function (Faker $faker) {
    return [
        'title'        => $faker->name,
        'description'  => $faker->realText(100),
        'reference_id' => Uuid::uuid4()->toString(),
        'created_by'   => fn() => factory(User::class)->create(),
        'tenant_id'    => fn() => factory(Tenant::class)->create(),
        'image'        => $faker->imageUrl(),
    ];
});
