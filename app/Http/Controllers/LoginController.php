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
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $respuesta['result'] = false;
                $respuesta['validator'] = $validator->errors()->all();
                $respuesta['mensaje'] = 'Error: Faltan datos.';
            } else {
                $usuario = new Usuario($request->all());
                try {
                    $user = Usuario::where('username', $usuario->username)->first();
                    if ($user) {
                        $admin = Administrador::where('user_id', $user->id)->first();
                        if ($admin) {
                            $user["tipo_usuario"] = "Administrador";
                        } else {
                            $user["tipo_usuario"] = "Portero";
                        }
                        if ($user && password_verify($usuario->password, $user->password)) {
                            $respuesta["mensaje"] = "Bienvenido";
                            $token = JWTAuth::fromUser($user, $this->getData($user));
                            $respuesta["token"] = $token;
                            $respuesta["user"] = $user;
                        } else {
                            $respuesta["mensaje"] = "Usuario o contraseña incorrecta.";
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

    private function getData($user)
    {
        $data = [
            'usuario' => [
                'username' => $user->id
            ]];

        $usuario = Usuario::where('username', $user->username)->first();
        if ($usuario) {
            $data['usuario']['datos'] = [
                'id' => $usuario->id,
                'username' => $usuario->username
            ];
        }
        return $data;
    }
}