<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class clienteModelo extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table='cliente';
    public $timestamps = false;
    protected $primaryKey ='idCliente';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable=[
        'idCliente', 
        'nombreCliente',
        'apellidoCliente',
        'correoCliente',
        'contrasenaCliente'
    ];
    public function reservas() {
        return $this->hasMany(Reserva::class);
    }
    public function prestamos()
{
    return $this->hasMany(Prestamo::class, 'idCliente');
}
}
