<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Habitacion;
use App\Models\Moteles;

class HabitacionesController extends Controller
{
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $habitaciones = Habitacion::all();
        if (count($habitaciones) > 0) {
            $respuesta["result"] = $habitaciones;
        } else {
            $respuesta["Mensaje"] = "No se hay registros.";
        }
        return $respuesta;
    }
    
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        'unique' => 'El número ' . $request->numero . ' ya existe en el hotel.',
        ];
        $rules = [
        'numero' => 'required|numeric',
        'motel_id' => 'exists:moteles,id|required|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['validator'] = $validator->errors()->all();
            $respuesta['mensaje'] = 'Error en los datos ingresados.';
        } else {
            $habitacion_existe = Habitacion::where("motel_id", $request->motel_id)->where("numero", $request->numero)->first();
            if ($habitacion_existe) {
                $respuesta["mensaje"] = "El número de habitación existe";
            } else {
                $habitacion = new Habitacion($request->all());
                $habitacion->save();
                
                if ($habitacion) {
                    $respuesta["mensaje"] = "Guardado correctamente";
                    $respuesta["result"] = $habitacion;
                } else {
                    $respuesta["mensaje"] = "Error al guardar";
                    $respuesta["result"] = false;
                }
            }
            
        }
        return $respuesta;
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int $numero
    * @return \Illuminate\Http\Response
    */
    public function show($numero)
    {
        $habitacion = Habitacion::where("numero", $numero)->first();
        
        if ($habitacion) {
            return $habitacion;
        } else {
            return $respuesta["mensaje"] = "No se encontraron resultados";
        }
    }
}