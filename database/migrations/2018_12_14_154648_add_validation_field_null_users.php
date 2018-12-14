<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidationFieldNullUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('youtube_url');
            $table->dropColumn('spotify_url');
            $table->dropColumn('podcast_url');
            $table->dropColumn('itunes_url');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('youtube_url',512)->nullable();
            $table->string('spotify_url',512)->nullable();
            $table->string('podcast_url',512)->nullable();
            $table->string('itunes_url',512)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
