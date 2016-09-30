<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Marca;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marca = Marca::all();

        if ($marca) {
            $respuesta["result"] = $marca;
        } else {
            $respuesta["mensaje"] = "No se encontraron resultados";
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
            'unique' => 'La marca ' . $request->marca . ' ya existe.',
        ];
        $rules = [
            'marca' => 'required|unique:marcas|string'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $marca = new Marca($request->all());
            $result = $marca->save();

            if ($result) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $marca;
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
        $marca = Marca::where("id", $id)->first();

        if ($marca) {
            $respuesta["result"]= $marca;
        } else {
            $respuesta["mensaje"] = "No hay resultados";
            $respuesta["result"]= false;
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
