<?php

use Faker\Generator as Faker;

$factory->define(App\Child::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'contact_name' => $faker->firstName,
        'contact_relationship' => 'parent',
        'contact_number' => $faker->phoneNumber
    ];
});
