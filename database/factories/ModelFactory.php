<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\V1\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'token' => hash('sha256', $faker->unique()->randomDigit),
    ];
});

$factory->define(App\Models\V1\Book::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(rand(5, 15)),
        'user_id' => 1
    ];
});
