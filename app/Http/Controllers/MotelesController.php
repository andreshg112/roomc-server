<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Administrador;
use Carbon\Carbon;

use App\Models\Motel;
use App\Models\Habitacion;
use App\Models\EntradaSalida;
use App\Models\Vehiculo;
use App\Models\Portero;
use DB;

class MotelesController extends Controller
{
    public function getHabitaciones($motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $habitaciones = Habitacion::where("motel_id", $motel_id)->get();
        if (count($habitaciones) > 0) {
            $respuesta["result"] = $habitaciones;
        } else {
            $respuesta["mensaje"] = "No hay registros.";
        }
        return $respuesta;
    }
    
    public function getHabitacionesLibres($motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        //Se consultan los porteros de un motel
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        //Habitaciones ocupadas de ese motel
        $habitaciones_ocupadas = EntradaSalida::select("habitacion_id")
        ->whereIn("portero_id", $porteros_id)
        ->whereNull('fecha_salida')
        ->get()
        ->toArray();
        //Habitaciones libres a partir de las ocupadas
        $habitaciones_libres = Habitacion::where("motel_id", $motel_id)
        ->whereNotIn('id', $habitaciones_ocupadas)
        ->get();
        if (count($habitaciones_libres) > 0) {
            $respuesta["result"] = $habitaciones_libres;
        } else {
            $respuesta["mensaje"] = "No hay registros.";
        }
        return $respuesta;
    }
    
    public function getEntradasSalidasFecha(Request $request, $motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $fecha = $request->input('fecha', Carbon::now());
        //Se consultan los porteros de un motel
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        if (count($porteros_id) > 0) {
            $respuesta["result"] = EntradaSalida::with('habitacion')
            ->whereIn("portero_id", $porteros_id)
            ->where(DB::raw('date(fecha_entrada)'), $fecha)
            ->orWhere(DB::raw('date(fecha_salida)'), $fecha)
            ->get();
            if (count($respuesta["result"]) <= 0) {
                $respuesta["mensaje"] = "No hay registros.";
            }
        } else {
            $respuesta["mensaje"] = "No hay registros.";
        }
        
        return $respuesta;
    }
    
    public function getAllVehiculos(Request $request, $motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $estan_dentro = $request->input('estan_dentro', 1);
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        $consulta_base = EntradaSalida::whereIn('portero_id', $porteros_id);
        if ($estan_dentro) {
            //Si estan dentro. Es lo mismo que $estan_dentro == 1
            $datos = $consulta_base->whereNull('fecha_salida');
        } else {
            $datos = $consulta_base->whereNotNull("fecha_salida");
        }
        $result = $datos->get();
        if (count($result) > 0) {
            $respuesta["result"] = $result;
        } else {
            $respuesta["mensaje"] = "No hay registros.";
        }
        return $respuesta;
    }
    
    public function getNumeroHabitaciones(Request $request, $motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $ocupadas = $request->input('ocupadas', 1);
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        $consulta_base = EntradaSalida::whereIn('portero_id', $porteros_id);
        
        if ($ocupadas) {
            $habitaciones_ocupadas = $consulta_base
            ->select("habitacion_id")
            ->whereNull('fecha_salida')
            ->get();
            
            $numeros_habitaciones_ocupadas = Habitacion::select("numero")
            ->where("motel_id", $motel_id)
            ->whereIn("id", $habitaciones_ocupadas)
            ->get();
            $respuesta["result"]["ocupadas"] = $numeros_habitaciones_ocupadas;
        } else {
            $habitaciones_ocupadas = $consulta_base->select("habitacion_id")
            ->whereNull('fecha_salida')
            ->get();
            
            $numeros_habitaciones_libres = Habitacion::select("numero")
            ->where("motel_id", $motel_id)
            ->whereNotIn("id", $habitaciones_ocupadas)
            ->get();
            
            $respuesta["result"]["libres"] = $numeros_habitaciones_libres;
            
        }
        return $respuesta;
    }
    
    public function getVehiculo($motel_id, $placa)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        $result = EntradaSalida::with(['habitacion', 'portero', 'portero.usuario'])->whereIn("portero_id", $porteros_id)
        ->whereNull('fecha_salida')
        ->where('placa', $placa)->first();
        if ($result) {
            $fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $result->fecha_entrada);
            $fecha_salida = Carbon::now();
            $result->fecha_salida = $fecha_salida->toDateTimeString();
            $result->tiempo = $fecha_salida->diffInSeconds($fecha_entrada);
            if ($result->habitacion->motel->cobra_por_habitacion) {
                //Cálculo del valor de la estadía
                $costo_hora = $result->habitacion->tipo_habitacion->costo_hora;
                $costo_fraccion = $result->habitacion->tipo_habitacion->costo_fraccion;
                $minutos_fraccion = $result->habitacion->motel->minutos_fraccion;
                $minutos_estadia = round($result->tiempo / 60);
                $minutos_adicionales_hora = $minutos_estadia <= 60 ? 0 : $minutos_estadia - 60;
                
                $result->valor_estadia = $costo_hora +
                ceil( $minutos_adicionales_hora / $minutos_fraccion ) * $costo_fraccion;
            }
            $respuesta['result'] = $result;
        } else {
            $respuesta['mensaje'] = 'El vehículo con la placa ' . strtoupper($placa) . ' no se encuentra dentro del motel.';
        }
        return $respuesta;
    }
    
    public function getAllRecordsEntradasSalidas(Request $request, $motel_id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $placa = $request->input('placa');
        $porteros_id = Portero::select('id')->where('motel_id', $motel_id)->get();
        
        $respuesta['result'] = EntradaSalida::whereIn("portero_id", $porteros_id)
        ->where('placa', $placa)
        ->get();
        if (count($respuesta['result']) <= 0) {
            $respuesta['mensaje'] = "No se encontraron registros asociados a la placa " . $placa;
            $respuesta['result'] = false;
        }
        return $respuesta;
    }
    
    /**
    * Store a newly created resource in storage.
    * POST /moteles
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        'exists' => 'El usuario seleccionado como administrador no existe.',
        ];
        $rules = [
        'nombre' => 'required|string',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'administrador_id' => 'required|exists:usuarios,id|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['validator'] = $validator->errors()->all();
            $respuesta['mensaje'] = 'Error con los datos ingresados.';
        } else {
            $motel = new Motel($request->all());
            if ($motel->save()) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $motel;
            } else {
                $respuesta["mensaje"] = "Error al guardar.";
            }
        }
        return $respuesta;
    }
    
    /**
    * Display the specified resource.
    * GET  /moteles/{id}
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $respuesta = [];
        $respuesta['result'] = false;
        $motel = Motel::find($id);
        if ($motel) {
            $respuesta["result"] = $motel;
        } else {
            $respuesta["mensaje"] = "No se encuentra registrado.";
        }
        return $respuesta;
    }
}