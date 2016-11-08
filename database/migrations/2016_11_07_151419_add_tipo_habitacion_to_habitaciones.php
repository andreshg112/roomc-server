<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoHabitacionToHabitaciones extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('habitaciones', function (Blueprint $table) {
            $table->mediumInteger('tipo_habitacion_id')->unsigned()->nullable();
            $table->foreign('tipo_habitacion_id')->references('id')
            ->on('tipo_habitaciones')->onUpdate('cascade');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('habitaciones', function (Blueprint $table) {
            $table->dropForeign('habitaciones_tipo_habitacion_id_foreign');
            $table->dropColumn('tipo_habitacion_id');
        });
    }
}