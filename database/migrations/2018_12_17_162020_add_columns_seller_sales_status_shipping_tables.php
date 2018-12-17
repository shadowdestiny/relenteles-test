<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSellerSalesStatusShippingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_sales', function (Blueprint $table) {
            $table->integer('shipping_status')->default(\App\SellerSale::STATES["NOT_SENT"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_sales', function (Blueprint $table) {
            //
        });
    }
}
