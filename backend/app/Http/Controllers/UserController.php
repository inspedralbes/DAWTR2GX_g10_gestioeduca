<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Obtenir tots els usuaris",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Llista d'usuaris obtinguda correctament"
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();

        // Si la solicitud es AJAX, devolver una respuesta JSON
        if (request()->wantsJson()) {
            return response()->json($users, 200);
        }

        // Si no es AJAX (es una solicitud tradicional), devolver una vista
        return view('users.users', compact('users'));
    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nou usuari",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades del nou usuari",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Joan"),
     *             @OA\Property(property="email", type="string", example="joan@example.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuari creat correctament"
     *     )
     * )
     */

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));  // Devuelve la vista 'create' con los roles disponibles
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|string|max:255' // Hacer la imagen opcional
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $userData = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ];

        // Solo agregar la imagen si está presente en la solicitud
        if ($request->has('image')) {
            $userData['image'] = $request->image;
        }

        $user = User::create($userData);

        if ($request->wantsJson()) {
            return response()->json($user, 201);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obtenir un usuari específic",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'usuari",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuari obtingut correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuari no trobat"
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (request()->wantsJson()) {
            return response()->json($user, 200);
        }

        return view('users.show', compact('user'));
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualitzar un usuari existent",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'usuari",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades actualitzades de l'usuari",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Joana"),
     *             @OA\Property(property="email", type="string", example="joana@example.com"),
     *             @OA\Property(property="password", type="string", example="654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuari actualitzat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuari no trobat"
     *     )
     * )
     */

    public function edit($id)
    {
        $user = User::findOrFail($id); // Obtener el usuario por ID
        $roles = Role::all(); // Obtener todos los roles
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
        // Pasar las variables a la vista
    }



    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'sometimes|required|exists:roles,id',
            'image' => 'sometimes|required|string|max:255'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $user->update($request->all());

        if ($request->wantsJson()) {
            return response()->json($user, 200);
        }

        return redirect()->route('users.index', $user->id)->with('success', 'User updated successfully');
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminar un usuari",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'usuari",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Usuari eliminat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuari no trobat"
     *     )
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(null, 204);
    }

    public function getAuthenticatedUser(Request $request)
    {
        // Obtener el usuario autenticado (suponiendo que estás usando Sanctum o Passport para la autenticación)
        return response()->json($request->user());  // Esto devuelve los datos del usuario autenticado
    }

    
}
