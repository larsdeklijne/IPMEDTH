<?php

use Illuminate\Support\Facades\Route;


// Laravel homepage
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('welcome');
});

// Authenitcation routes
Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
});

Route::get('/checkIfAuthenticated', 'AuthenticationController@checkIfAuthenticated');


// alle requesten waarbij er data opgevraagd of verstuurd wordt

// Logopedisten routes
Route::get('/logopedist/index', 'LogopedistenController@index')->middleware('checkToken');
Route::get('/logopedist/get/{id}', 'LogopedistenController@get')->middleware('checkToken');
Route::post('/logopedist/add', 'LogopedistenController@add')->middleware('checkToken');

// Patienten routes
Route::get('/patient/index', 'PatientenController@index')->middleware('checkToken');
Route::get('/patient/get/{id}', 'PatientenController@get')->middleware('checkToken');
Route::post('/patient/add', 'PatientenController@add')->middleware('checkToken');
Route::post('/patient/login', 'PatientenController@login')->middleware('checkToken');

//Route::post('/patient/add', 'PatientenController@add');

// Advies routes
Route::get('/advies/get/{id}', 'AdviesController@get');
Route::post('/advies/add', 'AdviesController@add');



// Logopedisten delete routes eventueel nodig
//Route::get('/logopedist/delete/{id}', 'LogopedistenController@delete');

