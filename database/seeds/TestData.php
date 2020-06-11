<?php

use Illuminate\Database\Seeder;

class TestData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logopedistId = rand(1, 100);
        $patientId = rand(1, 100);
        $timestamp = mt_rand(1, time());

        DB::table('logopedisten')->insert([
            'id' => $logopedistId,
            'voornaam' => Str::random(10),
            'tussenvoegsel' => 'de',
            'achternaam' => Str::random(10),
            'password' => Hash::make('password'),
            'locaties' => 'Zoetermeer, leiden',
            'email' => 'test2@gmail.com',
        ]);

        DB::table('patienten')->insert([
            'id' => $patientId,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '8/8/8',
            'locaties' => 'Zoetermeer, leiden',
            'wachtwoord' => Hash::make('wachtwoord'),
        ]);

        DB::table('logopedisten_patienten')->insert([
            'id' => rand(1, 100),
            'logopedist_id' => $logopedistId,
            'patient_id' => $patientId,
        ]);

        DB::table('adviezen')->insert([
            'id' => rand(1, 100),
            'patient_id' => $patientId,
            'advies' => Str::random(10),
            'beknopt_advies' => Str::random(5),
            'zichtbaar' => 0,
        ]);

    }
}
