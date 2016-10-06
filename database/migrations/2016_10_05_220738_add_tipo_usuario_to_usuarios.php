<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoUsuarioToUsuarios extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('primer_nombre', '20');
            $table->string('segundo_nombre', '20')->nullable();
            $table->string('primer_apellido', '20');
            $table->string('segundo_apellido', '20')->nullable();
            $table->enum('tipo_usuario', ['ADMIN', 'PORTERO'])->default('PORTERO');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('primer_nombre');
            $table->dropColumn('segundo_nombre');
            $table->dropColumn('primer_apellido');
            $table->dropColumn('segundo_apellido');
            $table->dropColumn('tipo_usuario');
        });
    }
}