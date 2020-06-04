<?php

namespace App\Http\Controllers;
use App\Logopedist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class LogopedistenController extends Controller
{
    public function index()
    {
        $alleLogopedisten = DB::table('logopedisten')->get();

        dd($alleLogopedisten);

    }

    public function get($id)
    {
        $logopedist = DB::table('logopedisten')
                        ->where('id', $id)
                        ->first();

        //return $logopedist;
        //return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        return response()->json($logopedist);
    }

    public function add(Request $request)
    {
        $voornaam = $request->input('voornaam');
        $achternaam = $request->input('achternaam');
        $wachtwoord = $request->input('wachtwoord');
        $locaties = 'Den Haag';
        $email = $request->input('email');

        return response()->json(['voornaam' => $voornaam, 'achternaam' => $achternaam, 'wachtwoord' => $wachtwoord, 'locaties' => $locaties, 'email' => $email]);
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
