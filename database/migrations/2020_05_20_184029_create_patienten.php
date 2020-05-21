<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatienten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patienten', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_nummer');
            $table->date('geboortedatum'); 
            $table->text('locaties');
            $table->string('wachtwoord');
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
        Schema::dropIfExists('patienten');
    }
}
