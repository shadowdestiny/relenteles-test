<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->unique(['product_id','user_id'],'user_products');
        });
        Schema::table('cars', function (Blueprint $table) {
            $table->unique(['product_id','user_id'],'user_products');
        });
        Schema::table('favorites', function (Blueprint $table) {
            $table->unique(['product_id','user_id'],'user_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropUnique('user_id');
        });
        Schema::table('cars', function (Blueprint $table) {
            $table->dropUnique('product_id');
        });
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropUnique('user_id');
        });
    }
}
