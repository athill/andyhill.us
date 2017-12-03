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



Route::get('/recipes/print/{id}', 'RecipesController@print');
Route::get('/recipes/export/{id}', 'RecipesController@export');


Route::get('/cfmeta', function() {
	return view('cfmeta');
});

Route::get('/{foo?}/{bar?}/{baz?}', function () {
    return view('app');
});
