<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersSeed::class);
         $this->call(CustomerSeed::class);
         $this->call(CategorySeed::class);
         $this->call(SellerSeed::class);
         $this->call(ProductsSeed::class);
         $this->call(SettingSeed::class);
    }
}
