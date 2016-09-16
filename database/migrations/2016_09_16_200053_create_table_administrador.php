<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdministrador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
          Schema::create('administradores', function(Blueprint $table){
            $table->increments('id');
            $table->foreign('user_id')
            ->references('id')
            ->on('usuarios')
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
        Schema::drop('administradores');
    }
}
