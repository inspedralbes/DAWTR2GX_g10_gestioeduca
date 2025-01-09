<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionService
{

    public function createQuestionForForm($form, $data)
    {
        // Crear la pregunta asociada al formulario
        $question = $form->questions()->create([
            'title' => $data['title'],
            'type' => $data['type'],
        ]);

        // Si la pregunta tiene opciones, las creamos
        if (!empty($data['options'])) {
            foreach ($data['options'] as $optionData) {
                // Usamos OptionService para crear las opciones
                app(OptionService::class)->createOptionForQuestion($question, $optionData);
            }
        }

        return $question;
    }


    public function getAllQuestions()
    {
        return Question::all();
    }

    public function getQuestionById($id)
    {
        return Question::find($id);
    }

    public function createQuestion(array $data)
    {
        return Question::create($data);
    }

    public function updateQuestion($id, array $data)
    {
        $question = Question::findOrFail($id);
        $question->update($data);
        return $question;
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
    }
}
