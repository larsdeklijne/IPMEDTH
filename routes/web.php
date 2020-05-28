<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
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

// Patienten routes
Route::get('/advies/get/{id}', 'AdviesController@get');
Route::post('/advies/add', 'AdviesController@add');

// Logopedisten routes misschien nodig??
//Route::get('/logopedist/delete/{id}', 'LogopedistenController@delete');

