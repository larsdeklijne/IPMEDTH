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

    // route:: localhost/api/authenticate
    Route::post('authenticate', 'AuthenticateController@authenticate');
});

Route::get('/checkIfAuthenticated', 'AuthenticateController@checkIfAuthenticated')->middleware('checkToken');

// Logopedisten routes
Route::get('/logopedist/index', 'LogopedistenController@index')->middleware('checkToken');
Route::get('/logopedist/get/{id}', 'LogopedistenController@get')->middleware('checkToken');
Route::get('/logopedist/getlocatie/{locatie}', 'LogopedistenController@getLocatie')->middleware('checkToken');
Route::post('/logopedist/add', 'LogopedistenController@add')->middleware('checkToken');

// Patienten routes
Route::get('/patient/index', 'PatientenController@index')->middleware('checkToken');
Route::get('/patient/get/{patient_nummer}', 'PatientenController@get')->middleware('checkToken');
Route::get('/patient/getlocatie/{locatie}', 'PatientenController@getLocatie')->middleware('checkToken');
Route::post('/patient/add', 'PatientenController@add')->middleware('checkToken');
Route::post('/patient/login', 'PatientenController@login')->middleware('checkToken');

// Advies routes
Route::get('/advies/get/{id}', 'AdviesController@get');
Route::post('/advies/add', 'AdviesController@add')->middleware('checkToken');
Route::get('/advies/delete/{id}', 'AdviesController@delete')->middleware('checkToken');
Route::post('/advies/update', 'AdviesController@update')->middleware('checkToken');
