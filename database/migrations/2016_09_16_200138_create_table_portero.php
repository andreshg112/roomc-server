<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
          Schema::create('porteros', function(Blueprint $table){
            $table->increments('id');
            $table->foreign('user_id')
            ->references('id')
            ->on('usuarios')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('motel_id')
            ->references('id')
            ->on('moteles')
            ->onDelete('cascade')
            ->onUpdate('cascade') ;       
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('porteros');
    }
}
