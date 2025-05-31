<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('idCliente');
            $table->string('nombreCliente', 50);
            $table->string('apellidoCliente', 50);
            $table->string('correoCliente', 60);
            $table->string('contrasenaCliente', 80);
            $table->enum('rol', ['administrador', 'usuario'])->default('usuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}