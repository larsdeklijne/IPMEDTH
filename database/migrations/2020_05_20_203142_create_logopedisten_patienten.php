<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogopedistenPatienten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logopedisten_patienten', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('logopedist_id');
            $table->unsignedBigInteger('patient_id');

            $table->foreign('logopedist_id')->references('id')->on('logopedisten');  
            $table->foreign('patient_id')->references('id')->on('patienten');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logopedisten_patienten');
    }
}
