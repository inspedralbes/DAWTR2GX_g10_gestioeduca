<?php


namespace App\Http\Controllers;


use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Tag(
 *     name="Forms",
 *     description="Endpoints per gestionar els formularis"
 * )
 */
class FormController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/forms/{formId}/questions-and-answers",
     *     summary="Obtenir preguntes i respostes d'un formulari",
     *     tags={"Forms"},
     *     @OA\Parameter(
     *         name="formId",
     *         in="path",
     *         required=true,
     *         description="ID del formulari",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preguntes i respostes obtingudes correctament",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formulari no trobat"
     *     )
     * )
     */
    public function getQuestionsAndAnswers($formId)
    {
        $form = Form::with(['questions.answers'])->find($formId);


        if (!$form) {
            return response()->json(['message' => 'Formulari no trobat'], 404);
        }


        return response()->json($form, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/forms",
     *     summary="Llistar tots els formularis",
     *     tags={"Forms"},
     *     @OA\Response(
     *         response=200,
     *         description="Llista de formularis obtinguda correctament",
     *     )
     * )
     */
   
     public function index(Request $request)
     {
         $forms = Form::all();
 
         if ($request->expectsJson()) {
             return response()->json($forms, 200);
         }
 
         return view('forms', compact('forms'));
     }
   


    /**
     * @OA\Get(
     *     path="/api/forms/{id}",
     *     summary="Obtenir un formulari específic per ID",
     *     tags={"Forms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del formulari",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades del formulari",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formulari no trobat"
     *     )
     * )
     */
    public function show(Request $request, $id)
{
    // Obtener el formulario con sus preguntas y respuestas
    $form = Form::with(['questions.answers'])->find($id);

    if (is_null($form)) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Formulario no encontrado'], 404);
        }

        return redirect()->route('forms.index')->with('error', 'Formulario no encontrado');
    }

    // Si es una solicitud JSON, devolver el formulario en formato JSON
    if ($request->expectsJson()) {
        return response()->json($form, 200);
    }

    // Pasar el formulario con las preguntas y respuestas a la vista
    return view('questions', compact('form'));
}



    /**
     * @OA\Post(
     *     path="/api/forms",
     *     summary="Crear un nou formulari",
     *     tags={"Forms"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", maxLength=255, example="Formulari d'exemple")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Formulari creat correctament",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validació"
     *     )
     * )
     */
     /**
     * Guardar un nuevo formulario
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);


        $form = Form::create($validatedData);


        if ($request->expectsJson()) {
            return response()->json($form, 201);
        }


        return redirect()->route('forms.index')->with('success', 'Formulario creado correctamente');
    }


    /**
     * @OA\Put(
     *     path="/api/forms/{id}",
     *     summary="Actualitzar un formulari existent",
     *     tags={"Forms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del formulari a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", maxLength=255, example="Títol actualitzat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulari actualitzat correctament",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $form = Form::find($id);


        if (is_null($form)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Formulario no encontrado'], 404);
            }


            return redirect()->route('forms.index')->with('error', 'Formulario no encontrado');
        }


        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 400);
            }


            return redirect()->back()->withErrors($validator)->withInput();
        }


        $form->update($validator->validated());


        if ($request->expectsJson()) {
            return response()->json($form, 200);
        }


        return redirect()->route('forms.index')->with('success', 'Formulario actualizado correctamente');
    }


    /**
     * @OA\Delete(
     *     path="/api/forms/{id}",
     *     summary="Eliminar un formulari",
     *     tags={"Forms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del formulari a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Formulari eliminat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formulari no trobat"
     *     )
     * )
     */
    public function destroy(Request $request, $id)
    {
        $form = Form::find($id);


        if (is_null($form)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Formulario no encontrado'], 404);
            }


            return redirect()->route('forms.index')->with('error', 'Formulario no encontrado');
        }


        $form->delete();


        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }


        return redirect()->route('forms.index')->with('success', 'Formulario eliminado correctamente');
    }
}



