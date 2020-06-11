<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogopedisten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @return void
     */
    public function up()
    {
        Schema::create('logopedisten', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voornaam');
            $table->string('tussenvoegsel')->nullable();
            $table->string('achternaam');
            $table->string('wachtwoord');
            $table->text('locaties');
            $table->string('email')->unique();
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
        Schema::drop('logopedisten');
    }
}
