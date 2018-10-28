<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsAndTracksTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artist_id')->unique()->index();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('track_id')->unique()->index();
            $table->string('name');
            $table->text('src_path');
            $table->string('storage_path')->nullable();
            $table->integer('artist_id')->unsigned();

            $table->foreign('artist_id')->references('id')->on('artists');

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
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('artists');
    }
}
