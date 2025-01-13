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
    <h1 class="text-3xl font-bold mb-6">Detalles del Formulario: <?php echo htmlspecialchars($form->name, ENT_QUOTES, 'UTF-8'); ?></h1>

    <!-- Mostrar mensajes de éxito -->
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            <?php echo htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <!-- Mostrar las preguntas y respuestas -->
    <?php foreach ($form->questions as $question): ?>
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($question->question, ENT_QUOTES, 'UTF-8'); ?></h3>

            <!-- Mostrar respuestas -->
            <ul class="list-disc pl-5">
                <?php foreach ($question->answers as $answer): ?>
                    <li><?php echo htmlspecialchars($answer->answer, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>

            <!-- Mostrar opciones si existen -->
            <?php if ($question->options->count() > 0): ?>
                <ul class="list-disc pl-5 mt-2">
                    <?php foreach ($question->options as $option): ?>
                        <li><?php echo htmlspecialchars($option->option, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!-- Botón para Volver a la Lista de Formularios -->
    <a href="<?php echo route('forms.index'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        Volver a la lista de formularios
    </a>
</div>
</body>
</html>
