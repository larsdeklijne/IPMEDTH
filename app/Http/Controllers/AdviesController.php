<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Adviezen;

class AdviesController extends Controller
{

    public function get($id)
    {
        $advies = DB::table('adviezen')
                    ->where('id', $id)
                    ->first();

        if(isset($advies)) {
            return response()->json([$advies], 200);
        } else {
            return response()->json('advies is niet gevonden voor meegegeven ID', 400);
        }
            
    }

    public function add(Request $request)
    {
        // patienten fields
            // id
            // patient_id
            // geboortedatum
            // locaties
            // wachtwoord
        
        // velden die verplicht zijn voor patienten, dus moeten ze gevalidate worden
        $veldenUitRequest = array(
            'patient_id' => $request->input('patient_id'),
            'advies' => $request->input('advies'),
            'beknopt_advies' => $request->input('beknopt_advies'),
            'zichtbaar' => $request->input('zichtbaar'),
        );

        json_encode($veldenUitRequest);

        $validator = Validator::make($veldenUitRequest, [
            'patient_id' => 'required|integer',
            'advies' => 'required',
            'beknopt_advies' => 'required',
            'zichtbaar' => 'required|boolean|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $advies = Adviezen::create([
            'patient_id' => $request->input('patient_id'),
            'advies' => $request->input('advies'),
            'beknopt_advies' => $request->input('beknopt_advies'),
            'zichtbaar' => $request->input('zichtbaar'),
        ]);

        $advies->save();

        return $advies;
    }

    public function update(Request $request)
    {
        // validation om ervoor te zorgen dat patient_id wordt meegegeven
        $veldenUitRequest = array(
            'patient_id' => $request->input('patient_id'),
        );

        json_encode($veldenUitRequest);

        $validator = Validator::make($veldenUitRequest, [
            'patient_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // zet de velden uit de request om in variabele
        $patient_id = $request->input('patient_id');
        $advies = $request->input('advies');
        $beknopt_advies = $request->input('beknopt_advies');
        $zichtbaar = $request->input('zichtbaar');

        // haal advies op uit database
        Adviezen::where('patient_id', $patient_id)
            ->update([
                'advies' => $advies,
                'beknopt_advies' => $beknopt_advies,
                'zichtbaar' => $zichtbaar
            ]);

        $advies = DB::table('adviezen')
            ->where('patient_id', $patient_id)
            ->first();
        
        if($advies->advies = $advies) {
            return response()->json('update = true');
        } else {
            return response()->json('update = false');
        }
        
    }

    public function delete($id)
    {
        $advies = Adviezen::find($id);

        if(isset($advies)){
            $advies->delete();
            return 'advies is gedelete';
        } else {
            return 'advies is niet gevonden';
        }

    }
}
