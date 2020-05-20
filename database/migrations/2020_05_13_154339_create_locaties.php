<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocaties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locaties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('naam');
            $table->timestamps();

            $table->foreign('id')->references('locatie_id')->on('locaties_logopedisten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locaties');
    }
}
