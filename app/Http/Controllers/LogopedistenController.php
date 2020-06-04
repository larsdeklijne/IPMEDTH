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
        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }

    public function add(Request $request)
    {
        // logopedisten fields
        // voornaam
        // tussenvoegsel
        // achternaam
        // wachtwoord
        // locaties
        // email

        echo "test";
        die;
        
        $logopedist = Logopedist::create([
            'voornaam' => 'Lars',
            'tussenvoegsel' => 'de',
            'achternaam' => 'Klijne', 
            'wachtwoord' => 'ditisgeheim',
            'locaties' => 'Leiden',
            'email' => 't222@gmail.com'
        ]);

        $logopedist->save();
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
