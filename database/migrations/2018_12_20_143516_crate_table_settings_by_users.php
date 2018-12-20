<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableSettingsByUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_for_sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('setting_id');
            $table->unsignedInteger('seller_id');
            $table->boolean('value')->default(false);

            $table->unique(['setting_id','seller_id'],'setting_seller');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('setting_id')->references('id')->on('settings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_by_users');
    }
}
