<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableSettingsByBuyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_for_buyers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('setting_id');
            $table->unsignedInteger('buyer_id');
            $table->boolean('value')->default(false);

            $table->unique(['setting_id','buyer_id'],'setting_buyer');
            $table->foreign('buyer_id')->references('id')->on('users');
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
        Schema::dropIfExists('setting_for_buyers');
    }
}
