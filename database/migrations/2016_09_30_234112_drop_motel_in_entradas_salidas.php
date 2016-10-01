<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMotelInEntradasSalidas extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('entradas_salidas', function (Blueprint $table) {
            $table->dropForeign('entradas_salidas_motel_id_foreign');
            $table->dropColumn('motel_id');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('entradas_salidas', function (Blueprint $table) {
            $table->integer('motel_id')->unsigned()->after('portero_id');
            $table->foreign('motel_id')
            ->references('id')
            ->on('moteles')
            ->onUpdate('cascade');
        });
    }
}