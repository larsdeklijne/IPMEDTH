<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogopedistenPatienten extends Model
{
    protected $table = 'logopedisten_patienten';

    protected $fillable = ['logopedist_id', 'patient_id'];
}
