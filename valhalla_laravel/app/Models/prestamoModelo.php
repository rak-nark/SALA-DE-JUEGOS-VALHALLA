<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoModelo extends Model
{
    use HasFactory;

    protected $table = 'prestamo'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idPrestamo'; // Clave primaria
    public $timestamps = false; // Deshabilitar timestamps
    public $incrementing = true; // Clave primaria autoincremental
    protected $keyType = 'int'; // Tipo de la clave primaria

    // Solo los campos existentes en la base de datos
    protected $fillable = [
        'idPrestamo',
        'fecha',
        'hora',
        'tiempodeuso',
        'reserva',
        'id_cliente',
        'id_consola'
    ];

    // Relación con Cliente
    public function cliente()
{
    return $this->belongsTo(clienteModelo::class, 'id_cliente');
}


    // Relación con Consola
    public function consola()
    {
        return $this->belongsTo(Consola::class, 'id_consola'); // Relación correcta con la tabla consola
    }

    // Cast de datos
    protected $casts = [
        'reserva' => 'boolean', // Mapea el campo `reserva` como booleano
    ];
}