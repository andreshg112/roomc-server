<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Usuario;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LoginController extends Controller
{
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // credenciales para loguear al usuario
        $usuario = new Usuario($request->all());
        try {
            $user = Usuario::where('username', $usuario->username)->first();
            if ($user->password == $usuario->password)  {
                $respuesta["mensaje"]="Bienvenido";
                $token = JWTAuth::fromUser($user, $this->getData($user));
                $respuesta["token"]=$token;
                $respuesta["user"]=$user;
                return $respuesta;
            } else {
                return $respuesta["mensaje"]="Usuario o contraseña incorrecta";
            }
        } catch (JWTException $e) {
            return $respuesta["mensaje"]= 'No se pudo crear el token';
        }
        return response()->json(compact('token'));
        
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