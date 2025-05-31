<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsolaSeeder extends Seeder
{
    public function run()
    {
        DB::table('consola')->insert([
            ['id' => 1, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 2, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 3, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 4, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 5, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 6, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 7, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 8, 'tipo' => '360', 'estado' => 'disponible'],
            ['id' => 9, 'tipo' => 'one', 'estado' => 'disponible'],
            ['id' => 10, 'tipo' => 'one', 'estado' => 'disponible'],
            ['id' => 11, 'tipo' => 'one', 'estado' => 'disponible'],
            ['id' => 12, 'tipo' => 'one', 'estado' => 'disponible'],
            ['id' => 13, 'tipo' => 'one', 'estado' => 'disponible'],
        ]);
    }
}