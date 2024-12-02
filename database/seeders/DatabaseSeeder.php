<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Primero las tablas padre
            AlmacenSeeder::class,
            CategoriaSeeder::class,
            ProveedorSeeder::class,
            
            // Luego las tablas hijas
            ProductoSeeder::class,
            ClienteSeeder::class,
            VentaSeeder::class,
            VentasDetallesSeeder::class,
            CompraSeeder::class,
        ]);
    }
}
