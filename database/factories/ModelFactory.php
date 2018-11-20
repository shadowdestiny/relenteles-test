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

use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;



$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'            => $faker->firstName,
        'last_name'             => $faker->lastName,
        'shipping_address'      => $faker->address,
        'shipping_city'         => $faker->city,
        'shipping_state'        => 1,
        'shipping_zipcode'      => $faker->numberBetween($min = 0, $max = 5),
        'email'                 => $email = $faker->unique()->email,
        'password'              => Hash::make('12345'),
        'type_user'             => User::BUYER,
        'api_token'             => JWTAuth::fromUser((object)['id'=>1],['email'=>$email]),
    ];
});
