<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocatiesLogopedisten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locaties_logopedisten', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('logopedist_id');
            $table->integer('locatie_id');
            $table->timestamps();

            $table->foreign('id')->references('id')->on('logopedisten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locaties_logopedisten');
    }
}
