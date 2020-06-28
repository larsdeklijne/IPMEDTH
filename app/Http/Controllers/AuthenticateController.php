<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Logopedist;
use DB;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function index()
    {
        // Retrieve all the users in the database and return them
        $logopedisten = Logopedist::all();
        return $logopedisten;

    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $ingelogteLogopedist = DB::table('logopedisten')
                                ->where('email', $request->input('email'))
                                ->first();

        // if no errors are encountered we can return a JWT
        return response()->json(['token' => $token, 'ingelogteLogopedist' => $ingelogteLogopedist]);
    }

    public function checkIfAuthenticated(Request $request) 
    {
        // functie wordt alleen aangeroepen als de token valid is,
        // als de token niet valid is wordt het request afgevangen in de try catch van de middleware
        
       $user = $request->input('user');

       return $user;
    }
}
