@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nou Usuari</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="last_name">Cognoms:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correu Electrònic:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Contrasenya:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="image">URL de la Imatge:</label>
            <input type="url" class="form-control" id="image" name="image" value="{{ old('image') }}">
        </div>

        <div class="form-group">
            <label for="role">Rol:</label>
            <select name="role_id" id="role" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nou: Camps per a cursos i divisions -->
        <div id="courseDivisionFields" style="display: none;">
            <div class="form-group">
                <label for="courses">Cursos:</label>
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
            <button type="submit" class="btn btn-primary w-100">Crear Usuari</button>
            <a href="{{ route('users.index') }}" class="btn btn-primary mt-3 w-100">Tornar a la Llista d'Usuaris</a>
        </div>
    </form>
</div>

<!-- Afegir aquest script al final -->
<script>
document.getElementById('role').addEventListener('change', function() {
    const courseDivisionFields = document.getElementById('courseDivisionFields');
    // Mostrar camps només per a professors (1) i alumnes (2)
    if (this.value == '1' || this.value == '2') {
        courseDivisionFields.style.display = 'block';
    } else {
        courseDivisionFields.style.display = 'none';
    }
});

// Executar l'esdeveniment change en carregar la pàgina per gestionar el valor inicial
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    roleSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection
