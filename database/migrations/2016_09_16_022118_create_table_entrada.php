<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEntrada extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function(Blueprint $table){
            $table->increments('id');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->string('placa');
            $table->string('tipo_vehiculo');
            $table->string('color');
            $table->string('marca');
            $table->foreign('motel_id')
                ->references('id')
                ->on('moteles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
             $table->foreign('habitacion_id')
                ->references('id')
                ->on('habitaciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');    
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entradas');
    }
}
