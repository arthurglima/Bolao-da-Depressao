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


Route::get('/boloes/{bolao_id}/convidar', 'BolaoController@getInvites');
Route::get('/boloes/{bolao_id}/moderacao', 'BolaoController@getModeracao');
Route::get('/boloes/{bolao_id}/palpites', 'BolaoController@getPalpites');
Route::get('/boloes/{bolao_id}/classificacao', 'BolaoController@getClassificacao');
Route::post('/boloes/palpites', 'BolaoController@salvarPalpites');
Route::resource('/boloes', 'BolaoController');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'user.admin'], function () {

  Route::get('/times/getbyname', 'TimeController@getTimesByName');

  Route::resource('/times', 'TimeController');

  Route::resource('/fase', 'FaseController');

  Route::resource('/jogo', 'JogoController');

  Route::resource('/campeonato', 'CampeonatoController');

});
