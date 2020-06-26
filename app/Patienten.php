<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patienten extends Model
{
    protected $table = 'patienten';

    protected $fillable = ['id','patient_nummer', 'geboortedatum', 'locatie', 'wachtwoord'];
}
