<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaSeeder extends Seeder
{
    public function run()
    {

        $clientes = DB::table('clientes')->pluck('id_cliente');

        if ($clientes->isEmpty()) {

            DB::table('clientes')->insert([
                'id_cliente' => 1,
                'nombre' => 'Cliente Default',
                'dni' => '00000000',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $clientes = collect([1]);
        }

        $startDate = Carbon::create(2024, 8, 1); 
        $endDate = Carbon::create(2024, 11, 30); 
        for ($i = 1; $i <= 2000; $i++) {
            $fecha = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));

            DB::table('ventas')->insert([
                'id_cliente' => $clientes->random(),
                'totalPagar' => 0, 
                'fecha_venta' => $fecha->format('Y-m-d'),
                'estado' => 'completado', 
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);
        }
    }
}