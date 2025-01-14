@extends('layouts.app')
@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="display-4 mb-2">Panel de Administrador</h1>
        <p class="text-muted">Selecciona una sección para administrar</p>
    </div>

    <div class="row g-4">
        <!-- Roles -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('roles.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-user-tag fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Roles</h5>
                        <p class="card-text small text-muted">Gestionar roles de usuario</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cursos -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('courses.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-graduation-cap fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Cursos</h5>
                        <p class="card-text small text-muted">Administrar cursos</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Asignaturas -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('subjects.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-book fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Asignaturas</h5>
                        <p class="card-text small text-muted">Gestionar asignaturas</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Usuarios -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-users fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text small text-muted">Administrar usuarios</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Grupos -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('groups.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-layer-group fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Grupos</h5>
                        <p class="card-text small text-muted">Gestionar grupos</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Divisiones -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('divisions.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-sitemap fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Divisiones</h5>
                        <p class="card-text small text-muted">Administrar divisiones</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Formularios -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('forms.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-clipboard-list fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Formularios</h5>
                        <p class="card-text small text-muted">Gestionar formularios</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Preguntas -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('questions.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-question-circle fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Preguntas</h5>
                        <p class="card-text small text-muted">Administrar preguntas</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Respuestas -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('answers.index') }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-comment-dots fa-2x mb-3" style="color: var(--primary-color)"></i>
                        <h5 class="card-title">Respuestas</h5>
                        <p class="card-text small text-muted">Gestionar respuestas</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection