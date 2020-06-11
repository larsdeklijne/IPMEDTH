<?php

use Illuminate\Database\Seeder;

class Seeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // logopedist
        DB::table('logopedisten')->insert([
            'id' => 2,
            'voornaam' => 'Jan',
            'tussenvoegsel' => 'de',
            'achternaam' => 'Jong',
            'password' => Hash::make('password'),
            'locatie' => 'Den-haag',
            'email' => 'jandejong@gmail.com',
        ]);
        
        // patient 1
        DB::table('patienten')->insert([
            'id' => 4,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '1997/5/8',
            'locatie' => 'Den-haag',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 1
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 2,
            'patient_id' => 4,
        ]);
        
        // patient 2
        DB::table('patienten')->insert([
            'id' => 5,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '1992/5/8',
            'locatie' => 'Den-haag',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 1
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 2,
            'patient_id' => 5,
        ]);

       // patient 1
       DB::table('patienten')->insert([
            'id' => 6,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '200/2/8',
            'locatie' => 'Den-haag',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 1
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 2,
            'patient_id' => 6,
        ]);
    }
}
