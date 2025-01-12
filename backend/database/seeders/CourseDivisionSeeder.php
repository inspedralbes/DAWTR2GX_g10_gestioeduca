<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseDivisionSeeder extends Seeder
{
    public function run()
    {
        // Truncar la tabla antes de la ejecución para asegurarse que no haya datos previos
        DB::table('course_division')->truncate();

        // Definir combinaciones únicas esperadas
        $courseDivisions = [
            ['course_id' => 1, 'division_id' => 3],
            ['course_id' => 1, 'division_id' => 4],
            ['course_id' => 1, 'division_id' => 5],
            ['course_id' => 1, 'division_id' => 6],
            ['course_id' => 1, 'division_id' => 7],
            ['course_id' => 2, 'division_id' => 3],
            ['course_id' => 2, 'division_id' => 4],
            ['course_id' => 2, 'division_id' => 5],
            ['course_id' => 2, 'division_id' => 6],
            ['course_id' => 2, 'division_id' => 7],
            ['course_id' => 3, 'division_id' => 3],
            ['course_id' => 3, 'division_id' => 4],
            ['course_id' => 3, 'division_id' => 5],
            ['course_id' => 3, 'division_id' => 6],
            ['course_id' => 3, 'division_id' => 7],
            ['course_id' => 4, 'division_id' => 3],
            ['course_id' => 4, 'division_id' => 4],
            ['course_id' => 4, 'division_id' => 5],
            ['course_id' => 4, 'division_id' => 6],
            ['course_id' => 4, 'division_id' => 7],
            ['course_id' => 5, 'division_id' => 1],
            ['course_id' => 5, 'division_id' => 2],
            ['course_id' => 6, 'division_id' => 1],
            ['course_id' => 6, 'division_id' => 2],
        ];

        // Contador para los registros insertados
        $insertedCount = 0;

        // Loop para insertar hasta 24 registros
        foreach ($courseDivisions as $entry) {
            // Verificar si ya se insertaron 24 registros
            if ($insertedCount >= 24) {
                break; // Detener la inserción si ya se han insertado 24 registros
            }

            // Realizar la inserción
            DB::table('course_division')->insert([
                'course_id' => $entry['course_id'],
                'division_id' => $entry['division_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Aumentar el contador
            $insertedCount++;
        }

        // Log para depuración
        //Log::info('Número de registros insertados: ' . $insertedCount);
    }
}

