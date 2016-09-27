<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Models\EntradaSalida;

class EntradasSalidasController extends Controller
{
    
    
    public function getAllVehiculos($estado){
        
        if($estado=="dentro"){
            $datos= EntradaSalida::whereNull('fecha_salida')->get();
        }else{
            $datos= EntradaSalida::whereNotNull("fecha_salida")->get();
        }
        
        if($datos) {
            return $datos;
        } else {
            return $respuesta["mensaje"]="No se encontraron registros.";
        }
        
    }
    
    public function getVehiculo($placa){
        
        $datos= EntradaSalida::where('placa', $placa)->first();
        $fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $datos->fecha_entrada);
        $fecha_salida = Carbon::now();
        $datos->fecha_salida = $fecha_salida;
        $datos->tiempo = $fecha_salida->diffInSeconds($fecha_entrada);
        
        if($datos) {
            return $datos;
        } else {
            return $respuesta["mensaje"]="No se encontraron registros.";
        }
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return EntradaSalida::all();
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $entrada_salida = new EntradaSalida($request->all());
        $entrada_salida->save();
        
        if($entrada_salida){
            $respuesta["mensaje"]="Guardado correctamente";
            $respuesta["datos"]=$entrada_salida;
        }else{
            $respuesta["mensaje"]="No se pudo guardar";
        }
        
        return $respuesta;
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $entrada_salida=EntradaSalida::where("id", $id)->first();
        
        if($entrada_salida){
            $respuesta["mensaje"]="Guardado correctamente";
            $respuesta["datos"]=$entrada_salida;
        }else{
            $respuesta["mensaje"]="No se pudo guardar";
        }
        
        return $respuesta;
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        /* $datos=EntradaSalida::where("placa", $placa)
        ->where("motel_id", $motel_id )->first();*/
        
        $entrada_salida = EntradaSalida::find($id);
        if($entrada_salida) {
            //Lo encuentra (por id)
            $entrada_salida->fill($request->all());
            $fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $entrada_salida->fecha_entrada);
            $fecha_salida = Carbon::now();
            $entrada_salida->fecha_salida = $fecha_salida;
            $entrada_salida->tiempo = $fecha_salida->diffInSeconds($fecha_entrada);
            $guardo = $entrada_salida->save();
            if ($guardo) {
                $respuesta['mensaje'] = "Actualizado correctamente.";
                $respuesta['registro'] = $entrada_salida;
            } else {
                $respuesta['mensaje'] = "No puedo actualizarse.";
            }
        } else {
            $respuesta['mensaje'] = "No esta registrado.";
        }
        return $respuesta;
    }
    
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}