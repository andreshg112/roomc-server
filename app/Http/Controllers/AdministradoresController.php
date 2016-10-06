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
        $datos = Administrador::where("user_id", $user_id)->first();
        if($datos){
            $respuesta = Motel::all();
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
        $respuesta = [];
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        'exists' => 'El usuario que intenta asignar como administrador no existe',
        ];
        $rules = [
        'user_id' => 'required|exists:usuarios,id|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $administrador = new Administrador($request->all());
            $result = $administrador->save();
            
            if ($result) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $administrador;
            } else {
                $respuesta["mensaje"] = "No se pudo guardar";
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
    public function show($user_id)
    {
        $administrador = Administrador::where("user_id", $user_id)->first();
        
        if ($administrador) {
            $respuesta["result"] = $administrador;
        } else {
            $respuesta["mensaje"] = "No se encontraron registros";
            $respuesta["result"] = false;
        }
        return $respuesta;
        
    }
}