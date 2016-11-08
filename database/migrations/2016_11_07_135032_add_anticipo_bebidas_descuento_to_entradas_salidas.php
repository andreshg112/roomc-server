<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnticipoBebidasDescuentoToEntradasSalidas extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('entradas_salidas', function (Blueprint $table) {
            $table->integer('anticipo')->default(0)->nullable()->after('habitacion_id');
            $table->integer('bebidas')->default(0)->nullable()->after('anticipo');
            $table->integer('descuento')->default(0)->nullable()->after('bebidas');
            $table->integer('valor_estadia')->default(0)->nullable()->after('descuento');
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
            $table->dropColumn('anticipo');
            $table->dropColumn('bebidas');
            $table->dropColumn('descuento');
            $table->dropColumn('valor_estadia');
        });
    }
}