<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();

        if ($usuarios) {
            $respuesta["result"] = $usuarios;
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
            'unique' => 'El usuario ' . $request->username . ' ya existe.',
            'min' => 'La :contraseña debe ser mayor a 5 caracteres.',
        ];
        $rules = [
            'username' => 'required|unique:usuarios|string',
            'password' => 'required|unique:usuarios|min:5|string'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $respuesta['result'] = false;
            $respuesta['validator'] = $validator->errors()->all();
        } else {
            $usuario = new Usuario($request->all());
            $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
            $result = $usuario->save();

            if ($result) {
                $respuesta["mensaje"] = "Guardado correctamente";
                $respuesta["result"] = $usuario;
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
        $usuario = Usuario::where("id",$id)->first();

        if ($usuario) {
            $respuesta["result"] = $usuario;
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
