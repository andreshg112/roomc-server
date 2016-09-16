<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
          Schema::create('vehiculos', function(Blueprint $table){
            $table->increments('id');
            $table->string('marca');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vehiculos');
    }
}
