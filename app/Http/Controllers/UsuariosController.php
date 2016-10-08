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
        $respuesta = [];
        $respuesta['result'] = false;
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
        $respuesta['result'] = false;
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
        $respuesta = [];
        $respuesta['result'] = false;
        $usuario = Usuario::where("id", $id)->first();

        if ($usuario) {
            $respuesta["result"] = $usuario;
        } else {
            $respuesta["mensaje"] = "No se encontraron registros";
        }
        return $respuesta;
    }
}
