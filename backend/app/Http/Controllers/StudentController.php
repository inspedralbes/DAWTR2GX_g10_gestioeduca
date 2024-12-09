<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        return response()->json(Student::all());
    }


    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'current_course' => 'nullable|string',
        ]);

        // Para encriptar la contraseña antes de guardarla
        $validated['password'] = bcrypt($request->input('password'));

        $student = Student::create($validated);

        return response()->json($student, 201);
    }


    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'nullable|string|min:8', // Si se proporciona una nueva contraseña
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'current_course' => 'nullable|string',
        ]);

         // Encriptar la nueva contraseña si es proporcionada
        if ($request->has('password')) {
            $validated['password'] = bcrypt($request->input('password'));
        }

        $student->update($validated);

        return response()->json($student);
    }


    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }
}
