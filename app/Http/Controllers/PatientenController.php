<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Patienten;
use App\Adviezen;
use App\Logopedist;
use DB;
use App\LogopedistenPatienten;

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
                        ->get()
                        ->toArray();

        // transformeer $patienten (laravel collection) naar normale PHP array
        // zodat array verder gemanipuleert en bewerkt kan worden
        //$patientenArray = $patienten->toArray();

        for($i = 0; $i < count($patienten); $i++) {
            $patient = $patienten[$i];

            if(!empty($patient->geboortedatum))
            {
                $geboortedatum = $patient->geboortedatum;
                $formatGeboortedatum = date("d-m-Y", strtotime($geboortedatum));

                // split string om de extra - te verwijderen
                $formatGeboortedatum1 = substr($formatGeboortedatum, 0, 5);
                $formatGeboortedatum2 = substr($formatGeboortedatum, -5);
                
                $finalGeboortedatum = $formatGeboortedatum1 . $formatGeboortedatum2;

                $patient->geboortedatum = $finalGeboortedatum;
            }
                
            // haal waardes op uit bijbehorende koppeltabel
            $logopedisten_patienten = DB::table('logopedisten_patienten')
                        ->where('patient_id', $patient->id)
                        ->first();

            $patientenArray[$i] = $patient;

            if(!empty($logopedisten_patienten)){
                $logopedistId = $logopedisten_patienten->logopedist_id;

                // haal logopedist op die gekoppeld is aan patient
                $gekoppeldeLogopedistArray = DB::table('logopedisten')
                                    ->where('id', $logopedistId)
                                    ->get()
                                    ->toArray();

                $patientenArray[$i]->logopedist = $gekoppeldeLogopedistArray[0];
            } else {
                $patientenArray[$i]->logopedist = [];
            }

            $adviesPatient = DB::table('adviezen')
                            ->where('patient_id', $patient->id)
                            ->get()
                            ->toArray();

            if(!empty($adviesPatient)) {
                $patientenArray[$i]->advies = $adviesPatient;
            } else {
                $patientenArray[$i]->advies = [];
            }
            
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
            'logopedist_id' => $request->input('logopedist_id'),
            'patient_nummer' => $request->input('patient_nummer'),
            'geboortedatum' => $request->input('geboortedatum'),
            'locatie' => $request->input('locatie'),
            'wachtwoord' => $request->input('wachtwoord'),
        );

        json_encode($veldenUitRequest);

        $validator = Validator::make($veldenUitRequest, [
            'logopedist_id' => 'required|integer',
            'patient_nummer' => 'required|integer|unique:patienten,patient_nummer',
            'geboortedatum' => 'required',
            'locatie' => 'required|string|max:255',
            'wachtwoord' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // haal wachtwoord uit request
        // hash het meegegeven wachtwoord
        $wachtwoord = $request->input('wachtwoord');
        $gehaste_wachtwoord = Hash::make($wachtwoord);

        // generate random id for patient
        $patient_id = rand(10, 1000);

        // geboortedatum in juiste format zetten
        // format in database: Y/M/D
        // format die binnenkomt: D/M/Y
        $geboortedatum = $request->input('geboortedatum');

        $formatGeboortedatum = date("Y-m-d", strtotime($geboortedatum));

        $patient = Patienten::create([
            'id' => $patient_id,
            'patient_nummer' => $request->input('patient_nummer'),
            'geboortedatum' => $formatGeboortedatum,
            'locatie' => $request->input('locatie'),
            'wachtwoord' => $gehaste_wachtwoord,
        ]);

        $patient->save();

        $logopedistenPatienten = LogopedistenPatienten::create([
            'logopedist_id' => $request->input('logopedist_id'),
            'patient_id' => $patient_id
        ]);

        $logopedistenPatienten->save();

        return response()->json(['patient' => $patient]);
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
            
            if(!empty($adviesDatabase)) {

                // check of het wachtwoord gehast is en klopt
                if (Hash::check($requestWachtwoord, $databaseWachtwoord)) {
                    return response()->json(['advies' => $adviesDatabase], 200);
                } else {
                    return response()->json('This password doest not exist by this user', 400);
                }

            } else {

                // check of het wachtwoord gehast is en klopt
                if (Hash::check($requestWachtwoord, $databaseWachtwoord)) {
                    return response()->json('patient heeft geen advies nog', 200);
                } else {
                    return response()->json('This password doest not exist by this user', 400);
                }

            }

        } else {
            return response('This user does not exist', 400);
        }
       
    }

    public function delete($patient_id)
    {
        $patient = Patienten::find($patient_id);

        if(isset($patient)){
            // verwijder gekoppelde advies
            $advies = DB::table('adviezen')
                        ->where('patient_id', $patient_id)
                        ->first();
        
            if(!empty($advies)) {
                $advies_id = $advies->id;
                $deleteAdvies = Adviezen::find($advies_id);
                $deleteAdvies->delete();
            }

            // verwijder gekoppelde advies
            $logopedist_patient = DB::table('logopedisten_patienten')
                            ->where('patient_id', $patient_id)
                            ->first();
            
            if(!empty($logopedist_patient)){
                $logopedist_patient_id = $logopedist_patient->id;
                $deleteLogopedistPatient = LogopedistenPatienten::find($logopedist_patient_id);
                $deleteLogopedistPatient->delete();
            }
               
            $patient->delete();

            return 'patient is gedelete';
        } else {
            return 'patient is niet gevonden';
        }
    }

}
