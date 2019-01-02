<?php

use Faker\Generator as Faker;

$factory->define(App\Child::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstname(),
        'last_name' => $faker->lastname()
    ];
});
