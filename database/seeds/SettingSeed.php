<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'code'                  => 'order_mode',
                'description'           => 'Order has been mode',
                'type'                  => 'notification_seller',
                'order'                 => 1,
            ],
            [
                'code'                  => 'order_shipped_seller',
                'description'           => 'Order has been shipped',
                'type'                  => 'notification_seller',
                'order'                 => 2,
            ],
            [
                'code'                  => 'order_played',
                'description'           => 'Order by buyer',
                'type'                  => 'notification_buyer',
                'order'                 => 1,
            ],
            [
                'code'                  => 'save_favorite',
                'description'           => 'Save favorite',
                'type'                  => 'notification_buyer',
                'order'                 => 2,
            ],
            [
                'code'                  => 'product_favorite',
                'description'           => 'Product favorite',
                'type'                  => 'notification_buyer',
                'order'                 => 3,
            ],

        ]);
    }
}
