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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'            => $faker->firstName,
        'last_name'             => $faker->lastName,
        'shipping_address'      => $faker->address,
        'shipping_city'         => $faker->city,
        'shipping_state'        => 1,
        'shipping_zipcode'      => $faker->numberBetween($min = 0, $max = 5),
        'email'                 => $faker->unique()->email,
        'password'              => app('hash')->make('12345'),
    ];
});
