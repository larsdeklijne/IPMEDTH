<?php

namespace App\Http\Controllers;

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

        dd($logopedist);
    }

    public function add()
    {
        
    }

    public function delete()
    {
        
    }

}
