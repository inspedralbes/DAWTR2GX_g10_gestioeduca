@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="url" class="form-control" id="image" name="image" value="{{ old('image') }}">
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role_id" id="role" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nuevo: Campos para cursos y divisiones -->
        <div id="courseDivisionFields" style="display: none;">
            <div class="form-group">
                <label for="courses">Courses:</label>
                <select name="courses[]" id="courses" class="form-control" multiple>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="divisions">Divisions:</label>
                <select name="divisions[]" id="divisions" class="form-control" multiple>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->division }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-primary w-100">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-primary mt-3 w-100">Back to Users List</a>
        </div>
    </form>
</div>

<!-- Agregar este script al final -->
<script>
document.getElementById('role').addEventListener('change', function() {
    const courseDivisionFields = document.getElementById('courseDivisionFields');
    // Mostrar campos solo para profesores (1) y alumnos (2)
    if (this.value == '1' || this.value == '2') {
        courseDivisionFields.style.display = 'block';
    } else {
        courseDivisionFields.style.display = 'none';
    }
});

// Ejecutar el evento change al cargar la página para manejar el valor inicial
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    roleSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection
