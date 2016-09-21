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
          Schema::create('habitaciones', function(Blueprint $table){
            $table->increments('id');
            $table->integer('numero');
            $table->integer('motel_id')->unsigned();
            $table->foreign('motel_id')
            ->references('id')
            ->on('moteles')
            ->onUpdate('cascade');
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
        Schema::drop('habitaciones');
    }
}
