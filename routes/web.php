<?php

use Illuminate\Support\Facades\Route;


// Laravel homepage
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('welcome');
});

// Logopedisten routes
Route::get('/logopedist/index', 'LogopedistenController@index');
Route::get('/logopedist/get/{id}', 'LogopedistenController@get');
Route::post('/logopedist/add', 'LogopedistenController@add');

// Patienten routes
Route::get('/patient/index', 'PatientenController@index');
Route::get('/patient/get/{id}', 'PatientenController@get');
Route::post('/patient/add', 'PatientenController@add');

// Advies routes
Route::get('/advies/get/{id}', 'AdviesController@get');
Route::post('/advies/add', 'AdviesController@add');



// Logopedisten delete routes eventueel nodig
//Route::get('/logopedist/delete/{id}', 'LogopedistenController@delete');

