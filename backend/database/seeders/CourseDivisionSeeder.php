<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseDivisionSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        // Deshabilitar las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Eliminar todos los registros de la tabla 'course_division'
        DB::table('course_division')->truncate();
        // Habilitar las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Datos de ejemplo para course_division
        $courseDivisions = [
            ['course_id' => 1, 'division_id' => 3],
            ['course_id' => 1, 'division_id' => 4],
            ['course_id' => 2, 'division_id' => 3],
            ['course_id' => 2, 'division_id' => 4],
            ['course_id' => 3, 'division_id' => 5],
            ['course_id' => 3, 'division_id' => 6],
            ['course_id' => 4, 'division_id' => 3],
            ['course_id' => 4, 'division_id' => 4],
            ['course_id' => 5, 'division_id' => 3],
            ['course_id' => 5, 'division_id' => 4],
        ];

        // Insertar los nuevos registros
        foreach ($courseDivisions as $data) {
            DB::table('course_division')->insert([
                'course_id' => $data['course_id'],
                'division_id' => $data['division_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
