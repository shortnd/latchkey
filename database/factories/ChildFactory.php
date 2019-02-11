<?php

use Cviebrock\EloquentSluggable\Services\SlugService;
use Faker\Generator as Faker;

$factory->define(App\Child::class, function (Faker $faker) {
    $first_name = $faker->firstname();
    $last_name = $faker->lastname();
    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'slug' => SlugService::createSlug(App\Child::class, 'slug', $first_name . ' ' . $last_name)
    ];
});
