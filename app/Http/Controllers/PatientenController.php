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

    public function get($patient_nummer)
    {
        $patient = DB::table('patienten')
                        ->where('patient_nummer', $patient_nummer)
                        ->get()
                        ->toArray();
        
        // haal waardes op uit bijbehorende koppeltabel
        $logopedisten_patienten = DB::table('logopedisten_patienten')
            ->where('patient_id', $patient[0]->id)
            ->first();

        // haal logopedist op die gekoppeld is aan patient
        $gekoppeldeLogopedist = DB::table('logopedisten')
                ->where('id', $logopedisten_patienten->logopedist_id)
                ->get()
                ->toArray();

        // haal advies op van de patient
        $adviesPatient = DB::table('adviezen')
            ->where('patient_id', $patient[0]->id)
            ->get()
            ->toArray();

        $patient[0]->logopedist = $gekoppeldeLogopedist[0];
        $patient[0]->advies = $adviesPatient;

        return $patient;
    }

    // route die alle patienten ophaalt van een bepaalde locatie
    // uiteindelijk retourneert de route 1 array, met daarin voor alle patienten het volgende:
    // patient:{
    //     data:{
    //         //patient data
    //     },
    //     logopedist:{
    //         //logopedist data
    //     },
    //     advies:{
    //         //advies data
    //     }
    // }
    // voor alle patienten worden de bijbehorende logopedist en advies opgehaald

    public function getLocatie(Request $request)
    {
        $locatie = $request->route('locatie');

        $patienten = DB::table('patienten')
                        ->where('locatie', $locatie)
                        ->get();

        // transformeer $patienten (laravel collection) naar normale PHP array
        // zodat array verder gemanipuleert en bewerkt kan worden
        $patientenArray = $patienten->toArray();
        
        for($i = 0; $i < count($patientenArray); $i++) {
            $patient = $patienten[$i];

            // haal waardes op uit bijbehorende koppeltabel
            $logopedisten_patienten = DB::table('logopedisten_patienten')
                        ->where('patient_id', $patient->id)
                        ->first();

            $logopedistId = $logopedisten_patienten->logopedist_id;

            // haal logopedist op die gekoppeld is aan patient
            $gekoppeldeLogopedist = DB::table('logopedisten')
                                ->where('id', $logopedistId)
                                ->get()
                                ->toArray();

            $adviesPatient = DB::table('adviezen')
                            ->where('patient_id', $patient->id)
                            ->get()
                            ->toArray();

            $patientenArray[$i]->logopedist = $gekoppeldeLogopedist;
            $patientenArray[$i]->advies = $adviesPatient;
        }

        return $patientenArray;
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

            $adviesDatabase = DB::table('adviezen')
                        ->where('patient_id', $patient->id)
                        ->first();

            // haal gehaste wachtwoord op  van patient uit database
            $databaseWachtwoord = $patient->wachtwoord;
            
            if(isset($adviesDatabase)) {

                // check of het wachtwoord gehast is en klopt
                if (Hash::check($requestWachtwoord, $databaseWachtwoord)) {
                    return response()->json(['advies' => $adviesDatabase], 200);
                } else {
                    return response()->json('This password doest not exist by this user', 400);
                }

            } else {

                // check of het wachtwoord gehast is en klopt
                if (Hash::check($requestWachtwoord, $databaseWachtwoord)) {
                    return response()->json('patient heeft geen advies nog', 400);
                } else {
                    return response()->json('This password doest not exist by this user', 400);
                }

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
