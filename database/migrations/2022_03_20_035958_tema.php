<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Temas', function(Blueprint $table){
            $table->bigIncrements('Codigo');
            $table->string('Nombre', 60);
            $table->string('PalabrasClave');
            $table->string('Descripcion');
            $table->integer('Vigencia');
            $table->unsignedBigInteger('CodigoUsuario');
            $table->foreign('CodigoUsuario')->references('Codigo')->on('Usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Temas');
    }
}
