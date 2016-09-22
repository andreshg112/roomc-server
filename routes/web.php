<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/moteles', 'MotelesController');

Route::resource('/administradores', 'AdministradoresController');
Route::get('/administradores/{administrador_id}/moteles', 'AdministradoresController@getMotelesByAdministrador');

Route::resource('/entradas-salidas', 'EntradasSalidasController');
Route::get('/entradas-salidas/vehiculos/{estado}', 
	'EntradasSalidasController@getAllVehiculos');
Route::get('/entradas-salidas/vehiculo/{placa}', 
	'EntradasSalidasController@getVehiculo');

Route::resource('/habitaciones', 'HabitacionesController');
Route::get('/habitaciones/{id}', 'HabitacionesController@show');
Route::resource('/habitaciones', 'HabitacionesController');
Route::get('/habitaciones/motel/{motel_id}', 
	'HabitacionesController@getHabitaciones');

Route::resource('/marcas', 'MarcasController');
Route::resource('/marcas/{id}', 'MarcasController');

Route::resource('/iniciar-sesion', 'LoginController');



