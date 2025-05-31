<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientoTable extends Migration
{
    public function up()
    {
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo', ['correctivo', 'preventivo', 'limpieza', 'actualizacion']);
            $table->string('descripcion', 250);
            $table->unsignedInteger('id_consola');
            $table->date('fecha_programada');
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('id_consola')->references('id')->on('consola');
            $table->index('estado');
            $table->index('fecha_programada');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mantenimiento');
    }
}