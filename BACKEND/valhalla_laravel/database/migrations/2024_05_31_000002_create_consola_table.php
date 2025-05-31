<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsolaTable extends Migration
{
    public function up()
    {
        Schema::create('consola', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 50);
            $table->enum('estado', ['disponible', 'no_disponible', 'mantenimiento'])->default('disponible');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consola');
    }
}