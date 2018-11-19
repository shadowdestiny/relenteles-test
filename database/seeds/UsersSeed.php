<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use \Carbon\Carbon as Carbon;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create();

        $faker = Faker::create();

        DB::table('users')->insert([
            [
                'first_name'            => 'Admin',
                'last_name'             => 'Admin',
                'shipping_address'      => $faker->address,
                'shipping_city'         => $faker->city,
                'shipping_state'        => 1,
                'shipping_zipcode'      => $faker->numberBetween($min = 0, $max = 5),
                'email'                 => 'admin@relentless.com',
                'password'              => app('hash')->make('12345'),
                'created_at'            => Carbon::now(),
            ],
        ]);

    }
}
