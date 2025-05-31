<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ClienteSeeder::class,
            ConsolaSeeder::class,
            // ...otros seeders si los tienes
        ]);
    }
}