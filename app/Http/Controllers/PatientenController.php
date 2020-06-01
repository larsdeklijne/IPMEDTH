<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PatientenController extends Controller
{
    public function index()
    {
        $allePatienten = DB::table('patienten')->get();
    }

    public function get($id)
    {
        $patient = DB::table('patienten')
                        ->where('id', $id)
                        ->first();

        dd($patient);
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
