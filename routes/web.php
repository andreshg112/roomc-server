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
	header('Location: https://twitter.com/Parking_Control');
    die();
	//return view('welcome');
});

//Todo lo que este dentro de este middleware, necesita ir con token.
Route::group(['middleware' => 'jwt.auth'], function () {
	Route::resource('/moteles', 'MotelesController');
	Route::get('/moteles/{id}/habitaciones', 'MotelesController@getHabitaciones');

	Route::get('/moteles/{id}/habitaciones-libres', 
		        'MotelesController@getHabitacionesLibres');

	Route::resource('/administradores', 'AdministradoresController');
	Route::get('/administradores/{administrador_id}/moteles', 'AdministradoresController@getMotelesByAdministrador');

	Route::resource('/entradas-salidas', 'EntradasSalidasController');
	Route::get('/entradas-salidas/vehiculos/{estado}', 
		'EntradasSalidasController@getAllVehiculos');
	Route::get('/entradas-salidas/vehiculo/{placa}', 
		'EntradasSalidasController@getVehiculo');

	Route::resource('/habitaciones', 'HabitacionesController');

	Route::resource('/marcas', 'MarcasController');
});

//El iniciar sesion queda fuera porque no se necesita token para iniciar sesion.
Route::resource('/iniciar-sesion', 'LoginController');