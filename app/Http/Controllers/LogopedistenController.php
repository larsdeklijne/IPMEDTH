<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Logopedist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class LogopedistenController extends Controller
{
    public function index(Request $request)
    {
        
        $alleLogopedisten = DB::table('logopedisten')->get();

        return response()->json([$alleLogopedisten]);
    }

    public function get($id)
    {
        $logopedist = DB::table('logopedisten')
                        ->where('id', $id)
                        ->first();

        return response()->json([$logopedist]);
    }

    public function getLocatie(Request $request)
    {
        $locatie = $request->route('locatie');

        $logopedisten = DB::table('logopedisten')
                        ->where('locatie', $locatie)
                        ->get();

        return response()->json([$logopedisten]);
    }

    public function add(Request $request)
    {
        // Velden logopedist
        // voornaam, tussenvoegsel, achternaam, wachtwoord, locaties, email
        // verplichte velden: voornaam, achternaam, wachtwoord, locaties, email

        // locaties komt binnen als array
        // transformeer naar string gescheiden door kommas tussen de locaties
        
        $locaties = 'den-haag';
        //$locatiesArray = $request->input('locaties');
        //$locaties = implode(",", $locatiesArray);

        // velden die verplicht zijn voor logopedist, dus moeten ze gevalidate worden
        $veldenUitRequest = array(
            'voornaam' => $request->input('voornaam'),
            'achternaam' => $request->input('achternaam'),
            'wachtwoord' => $request->input('wachtwoord'),
            'locaties' => $locaties,
            'email' => $request->input('email')
        );

        json_encode($veldenUitRequest);

        $validator = Validator::make($veldenUitRequest, [
            'voornaam' => 'required|string|max:255',
            'achternaam' => 'required|string|max:255',
            'wachtwoord' => 'required|string|email|max:255',
            'locaties' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // tussenvoegsel is niet verplicht
        // als tussenvoegsel niet voorkomt in het request, maak er een empty string van
        if(null !== $request->input('tussenvoegsel')){
            $tussenvoegsel = $request->input('tussenvoegsel');
        } else {
            $tussenvoegsel = '';
        }

        $logopedist = Logopedist::create([
            'voornaam' => $request->input('voornaam'),
            'tussenvoegesel' => $tussenvoegsel,
            'achternaam' => $request->input('achternaam'),
            'wachtwoord' => $request->input('wachtwoord'),
            'locaties' => $request->input('locaties'),
            'email' => $request->input('email')
        ]);

        return response()->json(compact('logopedist'), 201);

        $logopedist->save();
    }

    public function checkCredentials()
    {
        $email = $request->input('email');
        $wachtwoord = $request->input('password');

        


    }



    /*
        public function delete($id)
        {
            $logopedist = DB::table('logopedisten')
                            ->where('id', $id)
                            ->delete();
        }
    */
}
