<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('salidas', function(Blueprint $table){
            $table->increments('id');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->time('tiempo_trasncurrido');
            $table->string('placa');
            $table->string('tipo_vehiculo');
            $table->string('color');
            $table->string('marca');
            $table->integer('portero_id')->unsigned();
            $table->foreign('portero_id')
            ->references('id')
            ->on('porteros')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->integer('motel_id')->unsigned();
            $table->foreign('motel_id')
                ->references('id')
                ->on('moteles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
             $table->integer('habitacion_id')->unsigned();
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
        Schema::drop('salidas');
    }
}
