<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EuromillionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();
        foreach (range(1,1) as $index) {
            DB::table('euromillions_draws')->insert([
                [
                    'lottery_id'                        => $faker->numberBetween(1,100),
                    'draw_date'                         => Carbon::now(),
                    'result_regular_number_one'         => $faker->numberBetween(1,10),
                    'result_regular_number_two'         => $faker->numberBetween(1,10),
                    'result_regular_number_three'       => $faker->numberBetween(1,10),
                    'result_regular_number_four'        => $faker->numberBetween(1,10),
                    'result_regular_number_five'        => $faker->numberBetween(1,10),
                    'result_lucky_number_one'           => $faker->numberBetween(1,10),
                    'result_lucky_number_two'           => $faker->numberBetween(1,10),
                    'jackpot_amount'                    => $faker->numberBetween(100,4000),
                    'jackpot_currency_name'             => $faker->realText(255,2),
                ],
            ]);

        }
    }
}
