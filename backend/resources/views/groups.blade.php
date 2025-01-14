<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Grupos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Gestión de Grupos</h1>

        <!-- Mostrar mensajes de éxito o error -->
        <?php if (session('success')): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                <?php echo e(session('success')); ?>
            </div>
        <?php elseif (session('error')): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo e(session('error')); ?>
            </div>
        <?php endif; ?>

        <!-- Listado de Grupos -->
        <h2 class="text-2xl font-semibold mb-4">Lista de Grupos</h2>
        <table class="table-auto w-full border-collapse border border-gray-300 mb-8">
    <thead class="bg-gray-100">
        <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Nombre</th>
            <th class="border border-gray-300 px-4 py-2">Integrantes</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td class="border border-gray-300 px-4 py-2"><?php echo e($group->id); ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo e($group->name); ?></td>
                <td class="border border-gray-300 px-4 py-2">
                    <!-- Mostrar nombres de integrantes -->
                    <?php if($group->users->isEmpty()): ?>
                        <span class="text-gray-500">Sin integrantes</span>
                    <?php else: ?>
                        <ul class="list-disc list-inside">
                            <?php foreach ($group->users as $user): ?>
                                <li><?php echo e($user->name); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <!-- Editar -->
                    <a href="<?php echo e(route('groups.index', ['edit' => $group->id])); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                    <!-- Eliminar -->
                    <form action="<?php echo e(route('groups.destroy', $group->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                    </form>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


        <!-- Formulario Crear o Editar -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">
            <?php echo e(isset($_GET['edit']) ? 'Editar Grupo' : 'Crear Nuevo Grupo'); ?>
        </h2>
        <form action="<?php echo e(isset($_GET['edit']) ? route('groups.update', $_GET['edit']) : route('groups.store')); ?>" method="POST" class="bg-gray-100 p-6 rounded shadow-md">
            <?php echo csrf_field(); ?>
            <?php if (isset($_GET['edit'])): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Nombre del Grupo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo e(isset($_GET['edit']) ? htmlspecialchars($groups->firstWhere('id', $_GET['edit'])->name) : ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Descripción del Grupo</label>
                <input
                    type="text"
                    id="description"
                    name="description"
                    value="<?php echo e(isset($_GET['edit']) ? htmlspecialchars($groups->firstWhere('id', $_GET['edit'])->description) : ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="number_of_students" class="block text-gray-700 font-medium">Número de Estudiantes</label>
                <input
                    type="number"
                    id="number_of_students"
                    name="number_of_students"
                    value="<?php echo e(isset($_GET['edit']) ? htmlspecialchars($groups->firstWhere('id', $_GET['edit'])->number_of_students) : ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                    required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <?php echo e(isset($_GET['edit']) ? 'Actualizar' : 'Guardar'); ?>
            </button>
            <?php if (isset($_GET['edit'])): ?>
                <a href="<?php echo e(route('groups.index')); ?>" class="ml-2 text-gray-500 hover:underline">Cancelar</a>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
