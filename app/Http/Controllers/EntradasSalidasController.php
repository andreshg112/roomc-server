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
        return EntradaSalida::all();
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
        $messages = [
            'required' => 'El campo :attribute es requerido.',
        ];
        $rules = [
            'fecha_entrada' => 'required|string',
            'placa' => 'required|string',
            'tipo_vehiculo' => 'required|string',
            'color' => 'required|string',
            'marca' => 'required|string',
            'portero_id' => 'exists:porteros,id|required|int',
            'habitacion_id' => 'exists:habitaciones,id|required|numeric',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $entrada_salida = new EntradaSalida($request->all());
            $entrada_salida->save();

            if ($entrada_salida) {
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
        $entrada_salida = EntradaSalida::find($id);
        if ($entrada_salida) {
            $respuesta["mensaje"] = "Registro encontrado";
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
        $messages = [
            'required' => 'El campo :attribute es requerido.',
        ];
        $rules = [
            'fecha_entrada' => 'required|string',
            'placa' => 'required|string',
            'tipo_vehiculo' => 'required|string',
            'color' => 'required|string',
            'color' => 'required|string',
            'marca' => 'required|string',
            'portero_id' => 'exists:porteros,id|required|int',
            'habitacion_id' => 'exists:habitaciones,id|required|numeric',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
            $respuesta['mensaje'] = 'Error: Faltan datos.';
        } else {
            $entrada_salida = EntradaSalida::find($id)->first();
            if ($entrada_salida) {
                //Lo encuentra (por id)
                $entrada_salida->fill($request->all());
                $fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $entrada_salida->fecha_entrada);
                $fecha_salida = Carbon::now();
                $entrada_salida->fecha_salida = $fecha_salida;
                $entrada_salida->tiempo = $fecha_salida->diffInSeconds($fecha_entrada);
                $guardo = $entrada_salida->save();
                if ($guardo) {
                    $respuesta['mensaje'] = "Actualizado correctamente.";
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