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

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::resource('/moteles', 'MotelesController', ['only' => 'store', 'show']);
    Route::get('/moteles/{id}/habitaciones', 'MotelesController@getHabitaciones');

    Route::get('/moteles/{id}/habitaciones-libres',
        'MotelesController@getHabitacionesLibres');

    Route::get('/moteles/{motel_id}/vehiculos/{placa}',
        'MotelesController@getVehiculo');

    Route::get('/moteles/{motel_id}/vehiculos',
        'MotelesController@getAllVehiculos');

    Route::resource('/administradores', 'AdministradoresController', ['only' => 'store', 'show']);
    Route::get('/administradores/{administrador_id}/moteles', 'AdministradoresController@getMotelesByAdministrador');

    Route::resource('/entradas-salidas', 'EntradasSalidasController', ['only' => 'store', 'show', 'update']);

    Route::resource('/habitaciones', 'HabitacionesController', ['only' => 'store', 'show']);

    Route::resource('/porteros', 'PorterosController', ['only' => 'store', 'show']);

    Route::resource('/usuarios', 'UsuariosController', ['only' => 'store', 'show']);

});

//El iniciar sesion queda fuera porque no se necesita token para iniciar sesion.
Route::resource('/iniciar-sesion', 'LoginController', ['only' => 'store', 'show']);