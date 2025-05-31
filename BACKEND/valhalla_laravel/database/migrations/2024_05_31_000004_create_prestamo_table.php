<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamoTable extends Migration
{
    public function up()
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->increments('idPrestamo');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('tiempodeuso');
            $table->tinyInteger('reserva');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_consola');
            $table->foreign('id_cliente')->references('idCliente')->on('cliente')->onDelete('cascade');
            $table->foreign('id_consola')->references('id')->on('consola');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamo');
    }
}