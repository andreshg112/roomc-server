<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Portero;

class PorterosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $porteros = Portero::all();

        if ($porteros) {
            $respuesta["result"] = $porteros;
        } else {
            $respuesta["mensaje"] = "No se encontraron registros";
            $respuesta["result"] = false;
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
            'exists' => 'El :attribute que intenta asignar como :attribute no existe',
        ];
        $rules = [
            'user_id' => 'required|exists:usuarios,id|numeric',
            'motel_id' => 'required|exists:moteles,id|numeric'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $portero = new Portero($request->all());
            $result = $portero->save();

            if ($result) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $portero;
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
    public function show($user_id)
    {
        $portero = Portero::where("user_id", $user_id)->first();

        if ($portero) {
            $respuesta["result"] = $portero;
        } else {
            $respuesta["mensaje"] = "No se encontraron registros";
            $respuesta["result"] = false;
        }
        return $respuesta;

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
