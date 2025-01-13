<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Formularios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Gestión de Formularios</h1>


        <!-- Mostrar mensajes de éxito o error -->
        <?php if (session('success')): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                <?php echo session('success'); ?>
            </div>
        <?php elseif (session('error')): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo session('error'); ?>
            </div>
        <?php endif; ?>


        <!-- Listado de Formularios -->
        <h2 class="text-2xl font-semibold mb-4">Lista de Formularios</h2>
        <table class="table-auto w-full border-collapse border border-gray-300 mb-8">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Título</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forms as $f): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $f->id; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $f->title; ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <!-- Botón para Ver -->
                            <a href="{{ route('forms.show', $f->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver</a>

                            <!-- Botón para Editar -->
                            <a href="<?php echo route('forms.index', ['edit' => $f->id]); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>


                            <!-- Formulario para Eliminar -->
                            <form action="<?php echo route('forms.destroy', $f->id); ?>" method="POST" class="inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <!-- Formulario para Crear o Editar -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">
            <?php echo isset($_GET['edit']) ? 'Editar Formulario' : 'Crear Nuevo Formulario'; ?>
        </h2>
        <form action="<?php echo isset($_GET['edit']) ? route('forms.update', $_GET['edit']) : route('forms.store'); ?>" method="POST" class="bg-gray-100 p-6 rounded shadow-md">
            <?php if (isset($_GET['edit'])): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>
            <?php echo csrf_field(); ?>


            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Título del Formulario</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo isset($_GET['edit']) ? htmlspecialchars($forms->firstWhere('id', $_GET['edit'])->title) : ''; ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                    required>
            </div>


            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Guardar'; ?>
            </button>
            <?php if (isset($_GET['edit'])): ?>
                <a href="<?php echo route('forms.index'); ?>" class="ml-2 text-gray-500 hover:underline">Cancelar</a>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
