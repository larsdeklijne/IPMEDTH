<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdviesController extends Controller
{

    public function get($id)
    {
        $advies = DB::table('adviezen')
                    ->where('id', $id)
                    ->first();

        dd($advies);
    }

    public function add(Request $request)
    {
        // patienten fields
            // id
            // patient_nummer
            // geboortedatum
            // locaties
            // wachtwoord
        
    }

    /*
        public function delete($id)
        {
            
        }
    */
}
