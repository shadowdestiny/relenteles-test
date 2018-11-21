<?php

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
            ],
            [
                'name'                  => 'Classic',
                'description'           => 'Classic Description',
            ],
            [
                'name'                  => 'Modern',
                'description'           => 'Modern Description',
            ],
            [
                'name'                  => 'Rock',
                'description'           => 'Rock Description',
            ],
        ]);
    }
}
