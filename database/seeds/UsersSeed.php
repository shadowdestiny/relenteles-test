<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use \Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create();

        $faker = Faker::create();

        $email = 'admin@relentless.com';

        DB::table('users')->insert([
            [
                'first_name'            => 'Admin',
                'last_name'             => 'Admin',
                'shipping_address'      => $faker->address,
                'shipping_city'         => $faker->city,
                'shipping_state'        => 1,
                'shipping_zipcode'      => $faker->numberBetween($min = 0, $max = 5),
                'email'                 => $email,
                'password'              => Hash::make('12345'),
                'api_token'             => 'none',
                'type_user'             => User::SELLER,
                'created_at'            => Carbon::now(),
            ],
        ]);

        $user = User::where('email','=',$email)->first();
        $user->api_token = JWTAuth::fromUser($user,['email'=>'admin@relentless.com']);
        $user->save();

    }
}
