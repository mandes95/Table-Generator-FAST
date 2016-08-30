<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('tabelDinamis','TableController@index');

Route::get('getVariabel/{topik}','TableController@getVariable');

Route::get('getItemKategori/{kategori}','TableController@getItemKategori');

Route::get('getFakta/{topik}/{variabel}/{regional}','TableController@getFakta');

Route::get('getRegional/{topik}/{variabel}','TableController@getRegional');