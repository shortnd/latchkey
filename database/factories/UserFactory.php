<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => 'shortnd',
        'email' => 'admin@admin.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$xIHdeQH4lul8fY54.nLggep31FoVoDysjO.Hzf2ACFAmzEYFCnxW.', //P@ssword!
        'remember_token' => str_random(10),
    ];
});
