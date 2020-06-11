<?php

use Illuminate\Database\Seeder;

class Seeder1 extends Seeder
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
            'id' => 1,
            'voornaam' => 'Yvon',
            'tussenvoegsel' => 'van',
            'achternaam' => 'Dijk',
            'password' => Hash::make('password'),
            'locatie' => 'Leiden',
            'email' => 'yvonvandijk@gmail.com',
        ]);
        
        // patient 1
        DB::table('patienten')->insert([
            'id' => 1,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '1995/9/8',
            'locatie' => 'Leiden',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 1
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 1,
            'patient_id' => 1,
        ]);
        
        // patient 2
        DB::table('patienten')->insert([
            'id' => 2,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '1990/10/2',
            'locatie' => 'Leiden',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 2
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 1,
            'patient_id' => 2,
        ]);

        // patient 3
        DB::table('patienten')->insert([
            'id' => 3,
            'patient_nummer' => rand(1000, 5000),
            'geboortedatum' => '1985/5/4',
            'locatie' => 'Leiden',
            'wachtwoord' => Hash::make('password'),
        ]);

        // link tussen logopedist en patient 2
        DB::table('logopedisten_patienten')->insert([
            'logopedist_id' => 1,
            'patient_id' => 3,
        ]);

    

    }
}
