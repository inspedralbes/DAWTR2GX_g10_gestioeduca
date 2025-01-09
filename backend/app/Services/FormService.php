<?php

namespace App\Services;

use App\Models\Form;
use App\Models\Question;
use App\Models\Option;

class FormService
{
    public function create(array $data)
{
    // Crear el formulario
    $form = Form::create([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
    ]);

    // Crear las preguntas del formulario
    if (!empty($data['questions'])) {
        foreach ($data['questions'] as $questionData) {
            // Usamos el servicio para crear las preguntas asociadas
            $question = app(QuestionService::class)->createQuestionForForm($form, $questionData);
        }
    }

    return $form;
}


    public function getAllForms()
    {
        return Form::all();
    }

    public function getFormWithQuestionsAndAnswers($formId)
    {
        return Form::with(['questions.answers'])->find($formId);
    }

    public function createForm(array $data)
    {
        return Form::create($data);
    }

    public function updateForm(Form $form, array $data)
    {
        $form->update($data);
        return $form;
    }

    public function deleteForm(Form $form)
    {
        $form->delete();
    }
}
