<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Patienten;
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

    public function getLocatie(Request $request)
    {
        $locatie = $request->route('locatie');

        $patienten = DB::table('patienten')
                        ->where('locatie', $locatie)
                        ->get();

        $logopedisten = DB::table('logopedisten')
                        ->where('locatie', $locatie)
                        ->get();

        return response()->json(['patienten' => $patienten, 'logopedisten' => $logopedisten]);
    }

    public function add(Request $request)
    {
        // patienten fields
            // patient_nummer
            // geboortedatum
            // locaties
            // wachtwoord

        // velden die verplicht zijn voor patienten, dus moeten ze gevalidate worden
        $veldenUitRequest = array(
            'patient_nummer' => $request->input('patient_nummer'),
            'geboortedatum' => $request->input('geboortedatum'),
            'locaties' => $request->input('locaties'),
            'wachtwoord' => $request->input('wachtwoord'),
        );

        json_encode($veldenUitRequest);

        $validator = Validator::make($veldenUitRequest, [
            'patient_nummer' => 'required|integer',
            'geboortedatum' => 'required|date',
            'locaties' => 'required|string|max:255',
            'wachtwoord' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // haal wachtwoord uit request
        // hash het meegegeven wachtwoord
        $wachtwoord = $request->input('wachtwoord');
        $gehaste_wachtwoord = Hash::make($wachtwoord);

        $patient = Patienten::create([
            'patient_nummer' => $request->input('patient_nummer'),
            'geboortedatum' => $request->input('geboortedatum'),
            'locaties' => $request->input('locaties'),
            'wachtwoord' => $request->input('wachtwoord'),
            'gehaste_wachtwoord' => $gehaste_wachtwoord
        ]);

        $patient->save();

        return response()->json($patient);
    }

    public function login(Request $request)
    {
        $patient_nummer = $request->input('patient_nummer');
        $requestWachtwoord = $request->input('wachtwoord');

        $patient = DB::table('patienten')
            ->where('patient_nummer', $patient_nummer)
            ->first();

        if(isset($patient)){
            // haal gehaste wachtwoord op  van patient uit database
            $databaseWachtwoord = $patient->gehaste_wachtwoord;

            // check of het wachtwoord gehast is en klopt
            if (Hash::check($requestWachtwoord, $databaseWachtwoord)) {
                return response()->json([$requestWachtwoord, $databaseWachtwoord]);
            } else {
                return response()->json('This password doest not exist by this user', 400);
            }

        } else {
            return response('This user does not exist', 400);
        }
       
    }

    /*
        public function delete($id)
        {
            
        }
    */

}
