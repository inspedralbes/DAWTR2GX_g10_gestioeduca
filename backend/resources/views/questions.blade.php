<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Preguntas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-3xl font-bold mb-6">Gestión de Preguntas</h1>

        <!-- Mostrar mensajes de éxito o error -->
        <?php if (session('success')): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                <?= session('success') ?>
            </div>
        <?php elseif (session('error')): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <!-- Listado de preguntas -->
        <h2 class="text-2xl font-semibold mb-4">Listado de Preguntas</h2>
        <?php if ($questions->isEmpty()): ?>
            <p class="text-gray-500">No hay preguntas registradas.</p>
        <?php else: ?>
            <table class="table-auto w-full border-collapse border border-gray-300 mb-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Pregunta</th>
                        <th class="border border-gray-300 px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?= $question->id ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $question->question ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="<?= route('questions.show', $question->id) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver</a>
                                <a href="?edit=<?= $question->id ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                                <form action="<?= route('questions.destroy', $question->id) ?>" method="POST" class="inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Mostrar detalles de una pregunta específica -->
        <?php if (isset($viewingQuestion)): ?>
            <h2 class="text-2xl font-semibold mb-4">Detalles de la Pregunta</h2>
            <div class="bg-gray-100 p-4 rounded mb-6">
                <p><strong>ID:</strong> <?= $viewingQuestion->id ?></p>
                <p><strong>Pregunta:</strong> <?= $viewingQuestion->question ?></p>
            </div>
            <a href="<?= route('questions.index') ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Volver</a>
        <?php endif; ?>

        <!-- Formulario para Crear o Editar Preguntas -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">
            <?= isset($editingQuestion) ? 'Editar Pregunta' : 'Crear Nueva Pregunta' ?>
        </h2>
        <form 
            action="<?= isset($editingQuestion) ? route('questions.update', $editingQuestion->id) : route('questions.store') ?>" 
            method="POST" 
            class="bg-gray-100 p-6 rounded shadow-md"
        >
            <?= csrf_field() ?>
            <?php if (isset($editingQuestion)): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <div class="mb-4">
                <label for="question" class="block text-gray-700 font-medium">Texto de la Pregunta</label>
                <input 
                    type="text" 
                    id="question" 
                    name="question" 
                    value="<?= isset($editingQuestion) ? htmlspecialchars(old('question', $editingQuestion->question)) : htmlspecialchars(old('question')) ?>" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500" 
                    required
                >
                <?php if ($errors->has('question')): ?>
                    <p class="text-red-500 text-sm mt-2"><?= $errors->first('question') ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <?= isset($editingQuestion) ? 'Actualizar' : 'Guardar' ?>
            </button>
            <?php if (isset($editingQuestion)): ?>
                <a href="<?= route('questions.index') ?>" class="ml-2 text-gray-500 hover:underline">Cancelar</a>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
