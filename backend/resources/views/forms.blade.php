@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Encabezado y botón de retorno -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 mb-0">Gestión de Formularios</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Dashboard
        </a>
    </div>

    <!-- Mensajes de éxito o error -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Lista de Formularios -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2" style="color: var(--primary-color)"></i>
                        Lista de Formularios
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">ID</th>
                                    <th>Título</th>
                                    <th class="text-end px-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($forms as $form)
                                    <tr>
                                        <td class="px-4">{{ $form->id }}</td>
                                        <td>{{ $form->title }}</td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('forms.index', ['edit' => $form->id]) }}" 
                                               class="btn btn-sm btn-warning me-2">
                                                <i class="fas fa-edit me-1"></i>
                                                Editar
                                            </a>
                                            <form action="{{ route('forms.destroy', $form->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('¿Estás seguro de eliminar este formulario?')">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario para Crear o Editar -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-{{ isset($_GET['edit']) ? 'edit' : 'plus' }} me-2" 
                           style="color: var(--primary-color)"></i>
                        {{ isset($_GET['edit']) ? 'Editar Formulario' : 'Crear Nuevo Formulario' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($_GET['edit']) ? route('forms.update', $_GET['edit']) : route('forms.store') }}" 
                          method="POST">
                        @if(isset($_GET['edit']))
                            @method('PUT')
                        @endif
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Título del Formulario</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   value="{{ isset($_GET['edit']) ? $forms->firstWhere('id', $_GET['edit'])->title : '' }}" 
                                   required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                {{ isset($_GET['edit']) ? 'Actualizar' : 'Guardar' }}
                            </button>

                            @if(isset($_GET['edit']))
                                <a href="{{ route('forms.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Cancelar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
