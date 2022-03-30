<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Evento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Eventos', function(Blueprint $table){
            $table->bigIncrements('Codigo');
            $table->string('Titulo', 60);
            $table->string('Descripcion');
            $table->date('Fecha');
            $table->string('Imagen');
            $table->string('URL');
            $table->char('Vigencia', 1); //A: Activo, B: Baja
            $table->unsignedBigInteger('CodigoLineaTiempo');
            $table->foreign('CodigoLineaTiempo')->references('Codigo')->on('LineaTiempos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Eventos');
    }
}
