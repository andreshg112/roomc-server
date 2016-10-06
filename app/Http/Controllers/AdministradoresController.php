<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Administrador;
use App\Models\Motel;


class AdministradoresController extends Controller
{
    //Es byAdministrador, debe recibir administrador_id no user_id.
    public function getMotelesByAdministrador($administrador_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $administrador = Administrador::find($administrador_id);
        if($administrador){
            $moteles = Motel::where('administrador_id', $administrador_id)->get();
            if(count($moteles) > 0) {
                $respuesta['result'] = $moteles;
            } else {
                $respuesta['mensaje'] = 'No hay registros.';
            }
        } else {
            $respuesta['mensaje'] = "El administrador ingresado no existe.";
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
        $respuesta = [];
        $respuesta['result'] = false;
        $administradores = Administrador::all();
        if(count($administradores) > 0) {
            $respuesta["result"] = $administradores;
        } else {
            $respuesta["mensaje"] = "No se encontraron registros.";
        }
        return $respuesta;
    }
    
    public function store(Request $request)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        'exists' => 'El usuario que intenta asignar como administrador no existe',
        ];
        $rules = [
        'user_id' => 'required|exists:usuarios,id|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['mensaje'] = 'Error en los datos ingresados.';
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $administrador = new Administrador($request->all());
            $respuesta['result'] = $administrador->save();
            if ($respuesta['result']) {
                $respuesta['mensaje'] = "Guardado correctamente";
            } else {
                $respuesta["mensaje"] = "No se pudo guardar.";
            }
        }
        return $respuesta;
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $user_id
    * @return \Illuminate\Http\Response
    */
    public function show($administrador_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $administrador = Administrador::find($administrador_id);
        if ($administrador) {
            $respuesta['result'] = $administrador;
        } else {
            $respuesta['mensaje'] = "No se encontraron registros.";
        }
        return $respuesta;
    }
}