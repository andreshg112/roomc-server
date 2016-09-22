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
//Route::resource('/moteles/{id}', 'MotelesController');
Route::get('/moteles/{id}/habitaciones', 'MotelesController@getHabitaciones');


Route::resource('/administradores', 'AdministradoresController');
Route::get('/administradores/{administrador_id}/moteles', 'AdministradoresController@getMotelesByAdministrador');

Route::resource('/entradas-salidas', 'EntradasSalidasController');
Route::get('/entradas-salidas/vehiculos/{estado}', 
	'EntradasSalidasController@getAllVehiculos');
Route::get('/entradas-salidas/vehiculo/{placa}', 
	'EntradasSalidasController@getVehiculo');

Route::resource('/habitaciones', 'HabitacionesController');

Route::resource('/marcas', 'MarcasController');

Route::resource('/iniciar-sesion', 'LoginController');



