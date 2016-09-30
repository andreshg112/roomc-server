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
        $habitaciones = Habitacion::all();

        if ($habitaciones) {
            $respuesta["result"] = $habitaciones;
        } else {
            $respuesta["result"] = false;
            $respuesta["Mensaje"] = "No se encontraron resultados";
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
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El número ' . $request->numero . ' ya existe en el hotel.',
        ];
        $rules = [
            'numero' => 'required|numeric',
            'motel_id' => 'exists:Moteles,id|required|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
            $respuesta['mensaje'] = 'Error: Faltan datos.';
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
     * @param  int $id
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
