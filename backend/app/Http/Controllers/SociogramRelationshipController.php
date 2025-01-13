<?php

namespace App\Http\Controllers;

use App\Models\SociogramRelationship;
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

        foreach ($data['relationships'] as $relationship) {
            SociogramRelationship::create([
                'user_id' => $data['user_id'],
                'peer_id' => $relationship['peer_id'],
                'question_id' => $relationship['question_id'],
                'relationship_type' => $relationship['relationship_type'],
            ]);
        }

        return response()->json(['message' => 'Relaciones guardadas correctamente.'], 201);
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
