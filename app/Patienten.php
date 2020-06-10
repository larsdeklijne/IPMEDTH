<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patienten extends Model
{
    protected $table = 'patienten';

    protected $fillable = ['patient_nummer', 'geboortedatum', 'locaties', 'wachtwoord', 'gehaste_wachtwoord'];
}
