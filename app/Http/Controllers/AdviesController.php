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

        dd($advies);
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

    /*
        public function delete($id)
        {
            
        }
    */
}
