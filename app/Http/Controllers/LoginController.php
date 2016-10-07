<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;
use Mockery\CountValidator\Exception;
use Validator;

use App\Models\Usuario;
use App\Models\Administrador;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LoginController extends Controller
{
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $respuesta = [];
        $codigo = 200;
        //Por defecto sera false.
        //result sera un objeto diferente a false,  si la operacion es exitosa.
        $respuesta['result'] = false;
        $messages = [
        'required' => 'El campo :attribute es requerido.',
        ];
        $rules = [
        'username' => 'required|string',
        'password' => 'required|string',
        ];
        try {
            $validator = \Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $respuesta['validator'] = $validator->errors()->all();
                $respuesta['mensaje'] = 'Error: Faltan datos.';
            } else {
                $usuario = new Usuario($request->all());
                try {
                    $user = Usuario::where('username', $usuario->username)->first();
                    if ($user) {
                        if ($user && password_verify($usuario->password, $user->password)) {
                            if($user->tipo_usuario == 'ADMIN') {
                                $user->load('administrador', 'administrador.moteles'); //Carga los moteles
                                //de un administrador. Ver modelo Administrador.
                            } elseif ($user->tipo_usuario == 'PORTERO') {
                                //Carga el motel de un portero
                                $user->load(['portero', 'portero.motel']);
                            }
                            $respuesta['mensaje'] = "¡Bienvenido $user->primer_nombre $user->primer_apellido!";
                            $token = JWTAuth::fromUser($user);
                            $respuesta['token'] = $token;
                            $respuesta['result'] = $user;
                        } else {
                            $respuesta['mensaje'] = 'Usuario o contraseña incorrecta.';
                        }
                    } else {
                        $respuesta["mensaje"] = "Usuario o contraseña incorrecta.";
                    }
                } catch (JWTException $e) {
                    $respuesta["mensaje"] = 'No se pudo crear el token.';
                }
            }
        } catch (Exception $e) {
            $respuesta['error'] = $e->getMessage();
        }
        return response()->json($respuesta, $codigo);
    }
}