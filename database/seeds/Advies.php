<?php

use Illuminate\Database\Seeder;

class Advies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // logopedist
         DB::table('adviezen')->insert([
            'patient_id' => 1,
            'advies' => 'advies test',
            'beknopt_advies' => 'beknopt advies test',
            'zichtbaar' => 1,
        ]);
    }
}
