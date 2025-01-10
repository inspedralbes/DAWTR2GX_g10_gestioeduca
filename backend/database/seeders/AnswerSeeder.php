<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\User;  // Para acceder a los usuarios
use App\Models\Question;  // Para acceder a las preguntas
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén algunas preguntas y usuarios existentes
        $users = User::all();
        $questions = Question::all();

        // Verifica que haya usuarios y preguntas
        if ($users->isEmpty() || $questions->isEmpty()) {
            echo "No hay usuarios o preguntas suficientes para insertar respuestas.";
            return;
        }

        // Inserta respuestas de ejemplo
        foreach ($questions as $question) {
            // Para cada pregunta, asigna una respuesta aleatoria a un usuario aleatorio
            foreach ($users as $user) {
                Answer::create([
                    'answer' => 'Respuesta de ejemplo',  // Respuesta básica
                    'question_id' => $question->id,     // Relación con la pregunta
                    'student_id' => $user->id,          // Relación con el usuario (estudiante)
                ]);
            }
        }

        echo "Respuestas creadas correctamente.\n";
    }
}
