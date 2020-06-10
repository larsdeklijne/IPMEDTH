<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGehasteWachtwoordToPatienten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patienten', function (Blueprint $table) {
            $table->string('gehaste_wachtwoord')->after('wachtwoord');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patienten', function (Blueprint $table) {
            $table->dropColumn('gehaste_wachtwoord');
        });
    }
}
