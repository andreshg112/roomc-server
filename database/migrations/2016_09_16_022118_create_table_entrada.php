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
        Schema::create('entradas_salidas', function(Blueprint $table){
            $table->increments('id');
            $table->datetime('fecha_entrada');
            $table->datetime('fecha_salida');
            $table->string('placa');
            $table->string('tipo_vehiculo');
            $table->string('color');
            $table->string('marca');
            $table->enum('estado', array('dentro', 'fuera'));
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
            $table->timestamps();
            //$table->softDeletes();   
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entradas_salidas');
    }
}
