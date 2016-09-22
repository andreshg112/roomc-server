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
Route::get('/habitaciones/{id}', 'HabitacionesController@show'); // Por que esto?
// Es lo que hace el resource. No es necesario que hagas tu propio metodo.
// Ademas, esta repetido.
Route::resource('/habitaciones', 'HabitacionesController');

//Ruta mal escrita. Siguiendo las reglas:
// moteles/{motel_id}/habitaciones
//Es como de mayor a menor y en plural.
Route::get('/habitaciones/motel/{motel_id}', 
	'HabitacionesController@getHabitaciones');

//El resouce hace "todo", es decir que no debes preocuparte por get/id getall, post...
//Incluye todas.
Route::resource('/marcas', 'MarcasController');
Route::resource('/marcas/{id}', 'MarcasController'); //Esta esta de mas.

Route::resource('/iniciar-sesion', 'LoginController');



