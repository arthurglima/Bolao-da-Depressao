<?php

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
})->middleware('guest');


Auth::routes();

Route::resource('/boloes', 'BolaoController');
Route::resource('/times', 'TimeController');
Route::resource('/fase', 'FaseController');
Route::resource('/campeonato', 'CampeonatoController');
Route::get('/home', 'HomeController@index')->name('home');
