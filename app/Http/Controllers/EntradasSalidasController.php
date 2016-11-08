<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Administrador;
use App\Models\EntradaSalida;
use App\Models\Motel;
use App\Models\Portero;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        if (count($registros) > 0) {
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
        'habitacion_id.unique' => 'La habitación está ocupada.'
        ];
        $datos_recibidos = $request->all();
        $rules = [
        'placa' => "required|string",
        'tipo_vehiculo' => 'required|string|in:automovil,motocicleta,taxi',
        'color' => 'required|string',
        'marca' => 'required|string',
        'portero_id' => 'required|integer|exists:porteros,id,motel_id,' . $datos_recibidos['motel_id'],
        'motel_id' => 'exists:moteles,id|required|integer',
        'habitacion_id' => 'required|integer|exists:habitaciones,id,motel_id,' . $datos_recibidos['motel_id'] . '|unique:entradas_salidas,habitacion_id,NULL,id,fecha_salida,NULL'
        ];
        
        $porteros_id = Portero::select('id')->where('motel_id', $datos_recibidos['motel_id'])->get();
        $dentro = EntradaSalida::whereIn("portero_id", $porteros_id)
        ->where("placa", $datos_recibidos["placa"])
        ->whereNull('fecha_salida')
        ->get();
        
        if (count($dentro) > 0) {
            $respuesta["mensaje"] = "No se puede registrar la entrada porque el vehículo aparece registrado dentro del motel.";
        } else {
            $validator = \Validator::make($request->all(), $rules, $messages);
            $validator->sometimes(['anticipo'], 'integer|required', function($input) {
                //El anticipo debe ser entero y requerido si el motel cobra por habitación.
                return Motel::find($input->motel_id)->cobra_por_habitacion;
            });
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
    * Marca la salida de un vehículo en el motel.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $datos_recibidos = $request->all();
        $rules = [
        'fecha_salida' => 'required|date',
        'tiempo' => 'required|integer',
        'portero_id' => 'required|integer|exists:porteros,id,motel_id,' . $datos_recibidos['motel_id'],
        'motel_id' => 'exists:moteles,id|required|integer',
        'bebidas' => 'integer'
        ];
        $validator = \Validator::make($request->all(), $rules);
        $validator->sometimes(['descuento', 'valor_estadia'], 'integer|required_with:fecha_salida', function($input) {
            //El descuento debe ser entero y requerido si el motel cobra por habitación.
            return Motel::find($input->motel_id)->cobra_por_habitacion;
        });
        if ($validator->fails()) {
            $respuesta['mensaje'] = 'Error en los datos ingresados.';
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $entrada_salida = EntradaSalida::find($id);
            if ($entrada_salida) {
                //Lo encuentra (por id)
                if (!is_null($entrada_salida->fecha_salida)) {
                    $respuesta['mensaje'] = "Esta salida ya ha sido registrada.";
                } else {
                    $entrada_salida->fill($request->all());
                    $guardo = $entrada_salida->save();
                    if ($guardo) {
                        $respuesta['mensaje'] = "Se marcó la salida correctamente.";
                        $respuesta['result'] = $entrada_salida;
                    } else {
                        $respuesta['mensaje'] = "No pudo actualizarse.";
                    }
                }
            } else {
                $respuesta['mensaje'] = "No está registrado.";
            }
        }
        return $respuesta;
    }
}