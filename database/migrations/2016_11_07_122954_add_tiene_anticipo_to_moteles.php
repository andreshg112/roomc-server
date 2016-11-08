<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTieneAnticipoToMoteles extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('moteles', function (Blueprint $table) {
            $table->boolean('tiene_anticipo')->default(0)
            ->nullable()->after('administrador_id');
            
            $table->boolean('cobra_por_habitacion')->default(0)
            ->nullable()->after('tiene_anticipo');
            
            $table->smallInteger('minutos_fraccion')->default(60)
            ->nullable()->after('cobra_por_habitacion');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('moteles', function (Blueprint $table) {
            $table->dropColumn('tiene_anticipo');
            $table->dropColumn('cobra_por_habitacion');
            $table->dropColumn('minutos_fraccion');
        });
    }
}