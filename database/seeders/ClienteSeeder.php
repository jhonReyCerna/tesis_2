<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        // List of first names, first last names and second last names
        $nombres_masculinos = [
            'Juan', 'Pedro', 'Carlos', 'Javier', 'Antonio', 'Luis', 'Fernando', 'Manuel', 'Eduardo', 'Jaime',
            'Rubén', 'Ricardo', 'Esteban', 'Tomás', 'Simón', 'Álvaro', 'Felipe', 'Andrés', 'Oscar', 'Víctor',
            'Gabriel', 'Joaquín'
        ];

        $nombres_femeninos = [
            'Maria', 'Ana', 'Luisa', 'Carmen', 'Marta', 'José', 'Laura', 'Raquel', 'Elena', 'Sofia',
            'Beatriz', 'Isabel', 'Patricia', 'Cristina', 'Susana', 'Virginia', 'Verónica', 'Alicia', 'Irene',
            'Ángeles', 'Berta', 'Mónica', 'Valeria', 'Claudia', 'Eva', 'Marina', 'Diana'
        ];

        $primer_apellido = [
            'González', 'Rodríguez', 'Martínez', 'Hernández', 'López', 'Pérez', 'García', 'Sánchez', 'Díaz', 'Torres',
            'Ramírez', 'Vázquez', 'Fernández', 'Jiménez', 'Molina', 'Ruiz', 'Giménez', 'Ortiz', 'Moreno', 'Álvarez',
            'Ramón', 'Martín', 'Serrano', 'Crespo', 'Castro', 'Reyes', 'Blanco', 'Navarro', 'Muñoz', 'Cordero',
            'Herrera', 'Vidal', 'Moya', 'Marín', 'Pinto', 'Gil', 'Cano', 'Núñez', 'Lara', 'Salazar',
            'Ríos', 'Campos', 'Vera', 'Soto', 'Vega', 'Giménez', 'Prado', 'Delgado', 'López', 'Ramos',
            'Sierra', 'Suárez', 'Méndez', 'Alonso', 'Ferrer', 'Bravo', 'Hidalgo', 'Requena', 'Vargas', 'Bermúdez',
            'López', 'Moreno', 'Crespo', 'Villanueva', 'Robles', 'Acosta', 'Hernández', 'Linares', 'Pérez', 'Montero'
        ];

        $segundo_apellido = [
            'González', 'Rodríguez', 'Martínez', 'Hernández', 'López', 'Pérez', 'García', 'Sánchez', 'Díaz', 'Torres',
            'Ramírez', 'Vázquez', 'Fernández', 'Jiménez', 'Molina', 'Ruiz', 'Giménez', 'Ortiz', 'Moreno', 'Álvarez',
            'Ramón', 'Martín', 'Serrano', 'Crespo', 'Castro', 'Reyes', 'Blanco', 'Navarro', 'Muñoz', 'Cordero',
            'Herrera', 'Vidal', 'Moya', 'Marín', 'Pinto', 'Gil', 'Cano', 'Núñez', 'Lara', 'Salazar',
            'Ríos', 'Campos', 'Vera', 'Soto', 'Vega', 'Giménez', 'Prado', 'Delgado', 'López', 'Ramos',
            'Sierra', 'Suárez', 'Méndez', 'Alonso', 'Ferrer', 'Bravo', 'Hidalgo', 'Requena', 'Vargas', 'Bermúdez',
            'López', 'Moreno', 'Crespo', 'Villanueva', 'Robles', 'Acosta', 'Hernández', 'Linares', 'Pérez', 'Montero'
        ];

        $clientes = [];
        $emailsExistentes = []; // Array para almacenar los correos ya generados

        for ($i = 1; $i <= 500; $i++) {
            // Seleccionar un nombre masculino o femenino aleatoriamente
            $isMasculino = rand(0, 1); // 0 o 1 aleatorio para determinar el género
            if ($isMasculino) {
                $nombre = $nombres_masculinos[array_rand($nombres_masculinos)];
                $genero = 'Masculino';
            } else {
                $nombre = $nombres_femeninos[array_rand($nombres_femeninos)];
                $genero = 'Femenino';
            }

            $nombre_completo = $nombre . ' ' .
                                $primer_apellido[array_rand($primer_apellido)] . ' ' .
                                $segundo_apellido[array_rand($segundo_apellido)];

            // Generar el correo electrónico asegurándose de que sea único
            $email = strtolower(str_replace(' ', '', $nombre_completo)) . '@gmail.com';

            // Verificar si el correo ya existe, si es así, generar uno nuevo
            while (in_array($email, $emailsExistentes)) {
                $email = strtolower(str_replace(' ', '', $nombre_completo . rand(1000, 9999))) . '@gmail.com';
            }

            // Agregar el correo electrónico al array de correos existentes
            $emailsExistentes[] = $email;

            $telefono = '9' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $fecha_nacimiento = Carbon::now()->subYears(rand(20, 50))->subDays(rand(0, 365))->toDateString();

            $clientes[] = [
                'nombre' => $nombre_completo,
                'direccion' => 'Dirección del cliente ' . $i,
                'telefono' => $telefono,
                'email' => $email,
                'dni' => rand(10000000, 99999999),
                'fecha_nacimiento' => $fecha_nacimiento,
                'genero' => $genero, // Asignar el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('clientes')->insert($clientes);
    }
}
