<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name'                  => 'Tecnology',
                'description'           => 'Tecnology Description',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Classic',
                'description'           => 'Classic Description',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Modern',
                'description'           => 'Modern Description',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Rock',
                'description'           => 'Rock Description',
                'created_at'            => Carbon::now(),
            ],
        ]);
    }
}
