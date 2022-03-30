<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Usuarios', function(Blueprint $table){
            $table->bigIncrements('Codigo');
            $table->string('NombreUsuario', 40);
            $table->char('Vigencia', 1); //A: Activo, B: Baja
            $table->unsignedBigInteger('CodigoPersona');
            $table->foreign('CodigoPersona')->references('Codigo')->on('Personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
}
