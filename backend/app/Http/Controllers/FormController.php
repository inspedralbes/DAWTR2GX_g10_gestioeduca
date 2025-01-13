<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FormService;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="Forms",
 *     description="Endpoints per gestionar els formularis"
 * )
 */
class FormController extends Controller
{

    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function storeFormWithQuestions(Request $request, FormService $formService)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:forms,title',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.title' => 'required|string',
            'questions.*.type' => 'required|string|in:text,number,multiple,checkbox',
            'questions.*.placeholder' => 'nullable|string',
            'questions.*.context' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*.text' => 'required_with:questions.*.options|string',
            'questions.*.options.*.value' => 'nullable|integer',
        ]);

        $form = $this->formService->createForm($validatedData);

        return response()->json(['form' => $form], 201);
    }



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
    public function getQuestionsAndAnswers($formId, Request $request)
    {
        $form = Form::with(['questions.answers'])->find($formId);

        if (!$form) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Formulario no encontrado'], 404);
            }
            return redirect()->route('forms.index')->with('error', 'Formulario no encontrado');
        }

        if ($request->is('api/*')) {
            return response()->json($form, 200);
        }

        return view('forms.show', compact('form'));
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
        $forms = $this->formService->getAllForms();

        if ($request->is('api/*')) {
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
        // Cargar el formulario con preguntas, respuestas y opciones
        $form = Form::with(['questions.answers', 'questions.options'])->find($id);

        if (!$form) {
            // Si el formulario no se encuentra, devolvemos un mensaje de error
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Formulario no encontrado'], 404);
            }
            return redirect()->route('forms.index')->with('error', 'Formulario no encontrado');
        }

        // Si la solicitud es para la API, devolvemos el formulario con las preguntas y respuestas en formato JSON
        if ($request->is('api/*')) {
            return response()->json($form, 200);
        }

        // Si la solicitud es para una vista, renderizamos la vista 'detailsForm' con los datos del formulario
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $form = $this->formService->createForm($validatedData);

        if ($request->is('api/*')) {
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
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
        ]);

        $form = Form::findOrFail($id);
        $form = $this->formService->updateForm($form, $validatedData);

        if ($request->is('api/*')) {
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
        $form = Form::findOrFail($id);
        $this->formService->deleteForm($form);

        if ($request->is('api/*')) {
            return response()->json(null, 204);
        }

        return redirect()->route('forms.index')->with('success', 'Formulario eliminado correctamente');
    }

}
