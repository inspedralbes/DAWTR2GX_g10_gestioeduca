<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Form;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Obtén el formulario con ID 1 (asegúrate de que existe)
        $form = Form::first(); // Usa Form::find(1) si sabes que el ID es 1

        if (!$form) {
            throw new \Exception('No se encontró un formulario en la base de datos.');
        }

        // Inserta preguntas asociadas al formulario
        Question::create([
            'form_id' => $form->id,
            'title' => '¿Cuál es tu color favorito?',
        ]);

        Question::create([
            'form_id' => $form->id,
            'title' => '¿Qué opinas sobre la inteligencia artificial?',
        ]);
    }
}
