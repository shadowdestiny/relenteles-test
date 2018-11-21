<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('shipping_address',255);
            $table->string('shipping_city',255);
            $table->integer('shipping_state');
            $table->string('shipping_zipcode',50);
            $table->string('email',100)->unique();
            $table->string('api_token',1024);
            $table->string('password');
            $table->enum('type_user',[1,2]);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
