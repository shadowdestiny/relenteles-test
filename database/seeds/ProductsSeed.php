<?php

use App\Category;
use App\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class ProductsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user       = User::where('email','=','seller@seller.com')->first();
        $category   = Category::first();

        foreach (range(1,10) as $index) {
            DB::table('products')->insert([
                [
                    'name'                      => $faker->text(50),
                    'description'               => $faker->text(255),
                    'price'                     => 100,
                    'category_id'               => $category->id,
                    'seller_id'                 => $user->id,
                    'created_at'                => Carbon::now(),
                ],
            ]);
        }


    }
}
