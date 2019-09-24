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
    return view('contenido/contenido');
});

Route::get('/instituto', 'InstitutoController@index');
Route::post('/instituto/registrar', 'InstitutoController@store');
Route::put('/instituto/actualizar', 'InstitutoController@update');
Route::put('/instituto/desactivar', 'InstitutoController@desactivar');
Route::put('/instituto/activar', 'InstitutoController@activar');
  

/* Estas Rutas son para Roles*/
Route::get('/roles', 'RolesController@index');
Route::get('/roles/selectRol', 'RolesController@selectRol');

/* esto es para personas*/

Route::get('/persona', 'PersonaController@index');
Route::post('/persona/registrar', 'PersonaController@store');
Route::put('/persona/actualizar', 'PersonaController@update');
//Route::get('/persona/actualizar', 'PersonaController@prueba');


/* esto es para registro tipos*/
Route::get('/tipos', 'TiposController@index');
Route::get('/tipos/selectTipo', 'TiposController@selectTipo');

/* esto es pata los usuarios*/
Route::get('/user', 'UserController@index');
Route::post('/user/registrar', 'UserController@store');
Route::put('/user/actualizar', 'UserController@update');
Route::put('/user/desactivar', 'UserController@desactivar');
Route::put('/user/activar', 'UserController@activar');