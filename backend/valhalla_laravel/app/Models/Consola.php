<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consola extends Model
{
    protected $table = 'consola';
    protected $fillable = ['tipo', 'estado'];

    // Opcional: definir constantes para evitar strings mágicos
    const ESTADO_DISPONIBLE = 'disponible';
    const ESTADO_NO_DISPONIBLE = 'no_disponible';
    const ESTADO_MANTENIMIENTO = 'mantenimiento';
}
