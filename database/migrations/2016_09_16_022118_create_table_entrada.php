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
            $table->string('placa', 10);
            $table->enum('tipo_vehiculo', ['automovil', 'motocicleta', 'taxi']);
            $table->string('color', 10);
            $table->string('marca', 20);
            
            $table->integer('portero_id')->unsigned();
            $table->foreign('portero_id')
            ->references('id')
            ->on('porteros')
            ->onUpdate('cascade');
            
            $table->integer('habitacion_id')->unsigned();
            $table->foreign('habitacion_id')
            ->references('id')
            ->on('habitaciones')
            ->onUpdate('cascade');
            
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
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