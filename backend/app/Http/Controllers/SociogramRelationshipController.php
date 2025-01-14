<?php

namespace App\Http\Controllers;

use App\Models\SociogramRelationship;
use App\Models\Form;
use Illuminate\Http\Request;

class SociogramRelationshipController extends Controller
{
    /**
     * Listar todas las relaciones sociométricas.
     */
    public function index()
    {
        $relationships = SociogramRelationship::with(['user', 'peer', 'question'])->get();
        return response()->json($relationships, 200);
    }

    /**
     * Filtrar relaciones por usuario que respondió.
     */
    public function byUser($userId)
    {
        $relationships = SociogramRelationship::where('user_id', $userId)
            ->with(['peer', 'question'])
            ->get();

        return response()->json($relationships, 200);
    }

    /**
     * Guardar nuevas relaciones sociométricas.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id', // Usuario que responde
            'relationships' => 'required|array',
            'relationships.*.peer_id' => 'required|exists:users,id',
            'relationships.*.question_id' => 'required|exists:questions,id',
            'relationships.*.relationship_type' => 'required|in:positive,negative',
        ]);

        // Guardar las relaciones en la tabla sociogram_relationships
        foreach ($data['relationships'] as $relationship) {
            SociogramRelationship::create([
                'user_id' => $data['user_id'],
                'peer_id' => $relationship['peer_id'],
                'question_id' => $relationship['question_id'],
                'relationship_type' => $relationship['relationship_type'],
            ]);
        }

        // Incrementar el contador de respuestas en la tabla 'forms'
        // Puedes usar un formulario específico de sociograma si es necesario o simplemente incrementar el contador de respuestas
        $form = Form::find(3);  // Aquí estamos buscando el formulario sociograma con ID 3
        if ($form) {
            $form->increment('responses_count'); // Incrementa el contador de respuestas del formulario
        } else {
            return response()->json(['error' => 'Formulario sociograma no encontrado.'], 404);
        }

        // Devolver una respuesta exitosa
        return response()->json(['message' => 'Relaciones guardadas y contador de respuestas actualizado.'], 201);
    }

    /**
     * Eliminar una relación específica.
     */
    public function destroy($id)
    {
        $relationship = SociogramRelationship::findOrFail($id);
        $relationship->delete();

        return response()->json(['message' => 'Relación eliminada correctamente.'], 200);
    }
    //ver relaciones para hacer el sociograma
    public function getRelationships()
    {
        $relationships = SociogramRelationship::with(['user', 'peer']) // Relacionar 'user' y 'peer' con el modelo de Sociogram
            ->get()
            ->groupBy('relationship_type'); // Agrupar relaciones por tipo

        return response()->json($relationships);
    }
}
