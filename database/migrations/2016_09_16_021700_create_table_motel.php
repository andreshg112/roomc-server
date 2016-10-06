<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('moteles', function(Blueprint $table){
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('direccion', 50);
            $table->string('telefono', 20);
            $table->integer('administrador_id')->unsigned();
            $table->foreign('administrador_id')
            ->references('id')
            ->on('administradores')
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
        Schema::drop('moteles');
    }
}
