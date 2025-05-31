<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        DB::table('cliente')->insert([
            [
                'idCliente' => 1,
                'nombreCliente' => 'Juanito',
                'apellidoCliente' => 'Alimaña',
                'correoCliente' => 'juanitoalimana@gmail.com',
                'contrasenaCliente' => '$2y$10$fELwiODOSzqSaiOJCozJ4unJm6JeLoQvSylWGgHuqbuAG.SbOoj/2',
                'rol' => 'administrador'
            ],
            [
                'idCliente' => 2,
                'nombreCliente' => 'Pedrito',
                'apellidoCliente' => 'Navajas',
                'correoCliente' => 'pedritonavaja@gamil.com',
                'contrasenaCliente' => '$2y$10$/gKkAjUpn4mEO0j6HS1lOe6mFkeGCkhkv3gf.07UYVoP9JY4SgpCS',
                'rol' => 'administrador'
            ],
            [
                'idCliente' => 3,
                'nombreCliente' => 'Di Anggelo',
                'apellidoCliente' => 'Larrusso',
                'correoCliente' => 'dianggelo@gmail.com',
                'contrasenaCliente' => '$2y$10$tqIyzcMP/dDjOsLuTzczOuju7meEEWPMZgPm8RZueg0QIfI1Gu1qq',
                'rol' => 'administrador'
            ],
            [
                'idCliente' => 10,
                'nombreCliente' => 'Reserva Fisica',
                'apellidoCliente' => '',
                'correoCliente' => '',
                'contrasenaCliente' => '',
                'rol' => 'usuario'
            ],
            [
                'idCliente' => 50,
                'nombreCliente' => 'Usuario Eliminado',
                'apellidoCliente' => '',
                'correoCliente' => 'eliminado@valhalla.com',
                'contrasenaCliente' => '',
                'rol' => 'usuario'
            ],
        ]);
    }
}