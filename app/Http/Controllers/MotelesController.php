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
use App\Models\Usuarios;

class MotelesController extends Controller
{

    public function getHabitaciones($motel_id)
    {
        $habitaciones = Habitacion::where("motel_id", $motel_id)->get();

        if ($habitaciones) {
            $respuesta["result"]= $habitaciones;
        } else {
            $respuesta["mensaje"] = "No se encontraron resultados";
            $respuesta["result"]= false;
        }
        return $respuesta;
    }

    public function getHabitacionesLibres($motel_id)
    {
        $habitaciones_ocupadas = EntradaSalida::select("habitacion")
            ->where("motel_id", $motel_id)
            ->whereNull('fecha_salida')
            ->get()
            ->toArray();
        $habitaciones_libres = Habitacion::select("numero")
            ->where("motel_id", $motel_id)
            ->whereNotIn("numero", $habitaciones_ocupadas)
            ->get()
            ->toArray();
        return $habitaciones_libres;
    }

    public function getVehiculo($motel_id, $placa)
    {
        $respuesta = []; //Siempre es bueno inicializar.
        $respuesta['result'] = EntradaSalida::where("motel_id", $motel_id)
            ->where('placa', $placa)->first();
        if ($respuesta['result']) {
            $fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $respuesta['result']->fecha_entrada);
            $fecha_salida = Carbon::now();
            $respuesta['result']->fecha_salida = $fecha_salida;
            $respuesta['result']->tiempo = $fecha_salida->diffInSeconds($fecha_entrada);
        } else {
            $respuesta['result'] = false;
            $respuesta['mensaje'] = 'No se encuentra el vehiculo con esa placa.';
        }
        return $respuesta;
    }

    /**
     * Display a listing of the resource.
     * GET /moteles
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'Hice GET /moteles';
        //return Moteles::all(); 
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
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $motel = new Motel($request->all());
            $motel->save();

            if ($motel) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $motel;
            } else {
                $respuesta["mensaje"] = "Error al guardar";
                $respuesta["result"] = false;
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
        return Motel::find($id)->first();

    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH  /moteles/{id}
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /moteles/{id}
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
