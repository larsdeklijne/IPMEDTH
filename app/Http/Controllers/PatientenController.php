<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PatientenController extends Controller
{
    public function index()
    {
        $allePatienten = DB::table('patienten')->get();

        return response()->json([$allePatienten]);
    }

    public function get($id)
    {
        $patient = DB::table('patienten')
                        ->where('id', $id)
                        ->first();

        return response()->json([$patient]);
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

    public function login(Request $request)
    {
        $patient_nummer = $request->input('patient_nummer');
        $wachtwoord = $request->input('wachtwoord');

        $result = DB::table('patienten')
            ->where('patient_nummer' , $patient_nummer)
            ->where('wachtwoord', $wachtwoord)
            ->first();

        if(isset($result)){
            $resultArray = [$patient_nummer, $wachtwoord];
            return response()->json([$resultArray]);
        } else {
            return response('This user does not exist', 400);
        }
    }



    public function checkCredentials()
    {
        $email = $request->input('email');
        $wachtwoord = $request->input('password');

        


    }

    /*
        public function delete($id)
        {
            
        }
    */

}
