<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Moteles;
use App\Models\Administrador;
class MotelesController extends Controller
{
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
        $motel = new Moteles($request->all());
        $motel->save();
        return $motel;
    }

    /**
     * Display the specified resource.
     * GET  /moteles/{id}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        
          $datos=Administrador::where("user_id", $user_id)->first();

            if($datos==""){
                 $respuesta['mensaje'] = "Usted no es Administrador no tiene permiso.";
            }else{
              $respuesta= Moteles::all();  
            }

            return $respuesta;
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
