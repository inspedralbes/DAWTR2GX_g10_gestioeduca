<?php

namespace App\Services;

use App\Models\Option;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OptionService
{

    public function createOptionForQuestion($question, $data)
    {
        // Creamos la opción asociada a la pregunta
        Option::create([
            'text' => $data['text'],
            'value' => $data['value'],
            'question_id' => $question->id,  // Se asigna automáticamente
        ]);
    }

    public function getAllOptions()
    {
        return Option::all();
    }

    public function getOptionById($id)
    {
        return Option::find($id);
    }

    public function createOption(array $data)
    {
        return Option::create($data);
    }

    public function updateOption($id, array $data)
    {
        $option = Option::findOrFail($id);
        $option->update($data);
        return $option;
    }

    public function deleteOption($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
    }
}
