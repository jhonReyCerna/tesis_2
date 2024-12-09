<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AlmacenSeeder::class,
            CategoriaSeeder::class,
            ProveedorSeeder::class,
            
            ProductoSeeder::class,
            ClienteSeeder::class,
            VentaSeeder::class,
            VentasDetallesSeeder::class,
            CompraSeeder::class,
        ]);
    }
}
