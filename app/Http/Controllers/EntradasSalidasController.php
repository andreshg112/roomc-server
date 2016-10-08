<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Models\EntradaSalida;
use App\Models\Administrador;

class EntradasSalidasController extends Controller
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
        $registros = EntradaSalida::all();
        if(count($registros) > 0){
            $respuesta['result'] = $registros;
        } else {
            $respuesta['mensaje'] = 'No hay registros.';
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
        //'placa.unique' => 'El vehículo aparece dentro del lugar.',
        'habitacion_id.unique' => 'La habitación está ocupada.'
        ];
        $datos_recibidos = $request->all();
        $rules = [
        'placa' => "required|string|unique:entradas_salidas,placa,NULL,id,fecha_salida,NULL",
        'tipo_vehiculo' => 'required|string|in:automovil,motocicleta,taxi',
        'color' => 'required|string',
        'marca' => 'required|string',
        'portero_id' => 'required|integer|exists:porteros,id,motel_id,'.$datos_recibidos['motel_id'],
        'motel_id' => 'exists:moteles,id|required|integer',
        'habitacion_id' => 'required|integer|exists:habitaciones,id,motel_id,'.$datos_recibidos['motel_id'].'|unique:entradas_salidas,habitacion_id,NULL,id,fecha_salida,NULL'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['mensaje'] = 'Error en los datos ingresados.';
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $entrada_salida = new EntradaSalida($request->all());
            $entrada_salida->fecha_entrada = Carbon::now()->toDateTimeString();
            if ($entrada_salida->save()) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $entrada_salida;
            } else {
                $respuesta["mensaje"] = "No se pudo guardar";
            }
        }
        return $respuesta;
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $entrada_salida = EntradaSalida::find($id);
        if ($entrada_salida) {
            $respuesta["result"] = $entrada_salida;
        } else {
            $respuesta["mensaje"] = "No se pudo guardar";
        }
        return $respuesta;
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        ];
        $datos_recibidos = $request->all();
        $rules = [
        'fecha_salida' => 'required|date',
        'tiempo' => 'required|integer',
        'placa' => 'required|string',
        'tipo_vehiculo' => 'required|string',
        'color' => 'required|string',
        'color' => 'required|string',
        'marca' => 'required|string',
        'portero_id' => 'exists:porteros,id|required|int',
        'motel_id' => 'exists:moteles,id|required|integer',
        'habitacion_id' => 'required|integer|exists:habitaciones,id,motel_id,'.$datos_recibidos['motel_id']
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['mensaje'] = 'Error en los datos ingresados.';
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $entrada_salida = EntradaSalida::find($id)->first();
            if ($entrada_salida) {
                //Lo encuentra (por id)
                $entrada_salida->fill($request->all());
                $guardo = $entrada_salida->save();
                if ($guardo) {
                    $respuesta['mensaje'] = "Se marcó la salida correctamente.";
                    $respuesta['result'] = $entrada_salida;
                } else {
                    $respuesta['mensaje'] = "No puedo actualizarse.";
                }
            } else {
                $respuesta['mensaje'] = "No esta registrado.";
            }
        }
        return $respuesta;
    }
}