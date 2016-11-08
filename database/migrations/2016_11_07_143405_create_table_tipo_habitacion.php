<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoHabitacion extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('tipo_habitaciones', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('nombre', 30);
            $table->integer('costo_hora');
            $table->integer('costo_fraccion');
            
            $table->integer('motel_id')->unsigned();
            $table->foreign('motel_id')->references('id')
            ->on('moteles')->onUpdate('cascade');
            
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
        Schema::dropIfExists('tipo_habitaciones');
    }
}