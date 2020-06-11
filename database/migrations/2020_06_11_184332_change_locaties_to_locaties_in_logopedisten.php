<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLocatiesToLocatiesInLogopedisten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logopedisten', function (Blueprint $table) {
            $table->renameColumn('locaties', 'locatie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logopedisten', function (Blueprint $table) {
            //
        });
    }
}
