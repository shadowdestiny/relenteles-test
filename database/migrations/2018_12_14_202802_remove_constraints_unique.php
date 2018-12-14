<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveConstraintsUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropForeign('rates_product_id_foreign');
            $table->dropUnique('user_id');
        });
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign('cars_user_id_foreign');
            $table->dropUnique('product_id');
        });
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign('favorites_product_id_foreign');
            $table->dropUnique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
