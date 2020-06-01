<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logopedist extends Model
{
    protected $table = 'logopedisten';

    protected $fillable = ['voornaam', 'tussenvoegsel', 'achternaam', 'wachtwoord', 'locaties', 'email'];
}
