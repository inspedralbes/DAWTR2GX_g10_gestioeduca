@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Panel de Control</h1>
    <p>Selecciona una sección para administrar:</p>
    <div class="list-group">
        <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action">Roles</a>
        <a href="{{ route('courses.index') }}" class="list-group-item list-group-item-action">Cursos</a>
        <a href="{{ route('subjects.index') }}" class="list-group-item list-group-item-action">Asignaturas</a>
        <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">Usuarios</a>
        <a href="{{ route('groups.index') }}" class="list-group-item list-group-item-action">Grupos</a>
        <a href="{{ route('divisions.index') }}" class="list-group-item list-group-item-action">Divisiones</a>
        <a href="{{ route('forms.index') }}" class="list-group-item list-group-item-action">Formularios</a>
        <a href="{{ route('questions.index') }}" class="list-group-item list-group-item-action">Preguntas</a>
        <a href="{{ route('answers.index') }}" class="list-group-item list-group-item-action">Respuestas</a>
    </div>
</div>
@endsection
