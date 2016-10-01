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
    Route::resource('/moteles', 'MotelesController', ['only' => 'store', 'show']);
    Route::get('/moteles/{id}/habitaciones', 'MotelesController@getHabitaciones');

    Route::get('/moteles/{id}/habitaciones-libres',
        'MotelesController@getHabitacionesLibres');

    Route::get('/moteles/{motel_id}/vehiculos/{placa}',
        'MotelesController@getVehiculo');

    Route::resource('/administradores', 'AdministradoresController');
    Route::get('/administradores/{administrador_id}/moteles', 'AdministradoresController@getMotelesByAdministrador');

    Route::resource('/entradas-salidas', 'EntradasSalidasController');

    Route::get('/entradas-salidas/vehiculos/{estado}',
        'EntradasSalidasController@getAllVehiculos');

    Route::resource('/habitaciones', 'HabitacionesController');

    Route::resource('/marcas', 'MarcasController');

    Route::resource('/porteros', 'PorterosController');

    Route::resource('/usuarios', 'UsuariosController');
});

//El iniciar sesion queda fuera porque no se necesita token para iniciar sesion.
Route::resource('/iniciar-sesion', 'LoginController');