<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHabitacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
          Schema::create('habitacion', function(Blueprint $table){
            $table->increments('id');
            $table->integer('numero');
            $table->foreign('motel_id')
            ->references('id')
            ->on('motel')
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
        Schema::drop('habitacion');
    }
}
