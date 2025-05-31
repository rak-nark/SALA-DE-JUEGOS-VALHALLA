<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('monto')->nullable();
            $table->unsignedInteger('id_prestamo');
            $table->foreign('id_prestamo')->references('idPrestamo')->on('prestamo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta');
    }
}