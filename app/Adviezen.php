<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adviezen extends Model
{
    protected $table = 'adviezen';

    protected $fillable = ['patient_id', 'advies', 'beknopt_advies', 'zichtbaar'];
}
