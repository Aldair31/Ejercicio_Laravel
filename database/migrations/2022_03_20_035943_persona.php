<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Persona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Personas', function(Blueprint $table){
            $table->bigIncrements('Codigo');
            $table->string('Nombre', 40)->nullable();;
            $table->string('Apellidos', 40)->nullable();;
            $table->date('FechaNacimiento')->nullable();;
            $table->integer('Sexo')->nullable();;
            $table->string('Correo', 100);
            $table->string('Foto');
            $table->integer('Vigencia');
            $table->unsignedBigInteger('CodigoPais')->nullable();;
            $table->foreign('CodigoPais')->references('Codigo')->on('Pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Personas');
    }
}
