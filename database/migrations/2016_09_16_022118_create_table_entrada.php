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
            $table->datetime('fecha_salida')->nullable();
            $table->integer('tiempo')->nullable();            
            $table->string('placa');
            $table->string('tipo_vehiculo');
            $table->string('color');
            $table->string('marca');
            $table->integer('portero_id')->unsigned();
            $table->foreign('portero_id')
            ->references('id')
            ->on('porteros')
            ->onUpdate('cascade');
            $table->integer('motel_id')->unsigned();
            $table->foreign('motel_id')
                ->references('id')
                ->on('moteles')
                ->onUpdate('cascade');
             $table->integer('habitacion');
            $table->timestamps();
            $table->softDeletes();
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
