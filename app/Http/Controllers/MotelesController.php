<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Administrador;

use App\Models\Motel;
use App\Models\Habitacion;
use App\Models\EntradaSalida;
class MotelesController extends Controller
{

    public function getHabitaciones($motel_id){
        $habitaciones=Habitacion::where("motel_id", $motel_id)->get();
       
        if($habitaciones){
            return $habitaciones;
        } else {
            $respuesta["mensaje"]="No se encontraron resultados";
            return $respuesta;
        }
    }

    public function getHabitacionesLibres($motel_id){
        $habitaciones_ocupadas= EntradaSalida::select("habitacion")
                                ->where("motel_id", $motel_id)
                                ->whereNull('fecha_salida')
                                ->get()
                                ->toArray();
        $habitaciones_libres=Habitacion::select("numero")
                            ->where("motel_id", $motel_id)
                            ->whereNotIn("numero", $habitaciones_ocupadas)
                            ->get()
                            ->toArray();
        return $habitaciones_libres;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $motel = new Motel($request->all());
        $motel->save();

        if($motel){
            $respuesta["mensaje"]="Guardado correctamente";
            $respuesta["datos"]=$motel;
        } else {
            $respuesta["mensaje"]="Error al guardar";           
        }
        return $respuesta;
    }

    /**
     * Display the specified resource.
     * GET  /moteles/{id}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Motel::find($id)->first();
          
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH  /moteles/{id}
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /moteles/{id}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
