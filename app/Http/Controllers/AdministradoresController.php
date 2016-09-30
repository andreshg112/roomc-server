<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Administrador;
use App\Models\Motel;


class AdministradoresController extends Controller
{
    public function getMotelesByAdministrador($user_id)
    {
        $datos=Administrador::where("user_id", $user_id)->first();

        if($datos){
            $respuesta= Motel::all();
        } else {
            $respuesta['mensaje'] = "Usted no es Administrador no tiene permiso.";
        }
        return $respuesta;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $administradores=Administrador::all();

        if($administradores){
             $respuesta["result"]=$administradores;
        } else {
             $respuesta["mensaje"]="No se encontraron registros";
            $respuesta["result"]=false;
        }
        return $respuesta;
    }

    public function store(Request $request)
    {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}