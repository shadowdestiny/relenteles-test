<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SellerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('users')->insert([
            [
                'first_name'            => 'Buyer',
                'last_name'             => 'Buyer',
                'shipping_address'      => $faker->address,
                'shipping_city'         => $faker->city,
                'shipping_state'        => User::STATES["NOT_SENT"],
                'shipping_zipcode'      => $faker->numberBetween($min = 0, $max = 5),
                'email'                 => 'seller@seller.com',
                'password'              => Hash::make('12345'),
                'api_token'             => 'none',
                'type_user'             => User::SELLER,
                'created_at'            => Carbon::now(),
                'image'                 => 'none'
            ],
        ]);
    }
}
