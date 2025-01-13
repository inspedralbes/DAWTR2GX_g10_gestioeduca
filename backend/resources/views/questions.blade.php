<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Formulario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Detalles del Formulario: {{ $form->name }}</h1>

    <!-- Mostrar mensajes de éxito -->
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar las preguntas y respuestas -->
    @foreach ($form->questions as $question)
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">{{ $question->question }}</h3>

            <!-- Mostrar respuestas -->
            <ul class="list-disc pl-5">
                @foreach ($question->answers as $answer)
                    <li>{{ $answer->answer }}</li>
                @endforeach
            </ul>

            <!-- Mostrar opciones si existen -->
            @if ($question->options->count() > 0)
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($question->options as $option)
                        <li>{{ $option->option }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach

    <!-- Botón para Volver a la Lista de Formularios -->
    <a href="{{ route('forms.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        Volver a la lista de formularios
    </a>
</div>
</body>
</html>
