<?php

use Faker\Generator as Faker;
use Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(App\Child::class, function (Faker $faker) {
    $first_name = $faker->firstname();
    $last_name = $faker->lastname();
    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'slug' => SlugService::createSlug(App\Child::class, 'slug', $first_name . ' ' . $last_name)
    ];
});
