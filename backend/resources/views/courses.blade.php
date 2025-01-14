<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Gestión de Cursos</h1>
    <!-- Mostrar mensajes de éxito -->
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            <?php echo session('success'); ?>
        </div>
    <?php endif; ?>


    <!-- Mostrar errores de validación -->
    <?php if (!empty($errors)): ?>
        <div class="text-red-700 px-4 py-2 rounded mb-4">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <!-- Listado de cursos -->
    <h2 class="text-2xl font-semibold mb-4">Lista de Cursos</h2>
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $course->id; ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $course->name; ?></td>
                    <td class="border border-gray-300 px-4 py-2">
                        <!-- Botón para Cargar Datos en el Formulario -->
                        <form action="<?php echo route('courses.index'); ?>" method="GET" class="inline">
                            <input type="hidden" name="edit" value="<?php echo $course->id; ?>">
                            <button type="submit"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                Editar
                            </button>
                        </form>

                        <!-- Formulario para Eliminar -->
                        <form action="<?php echo route('courses.destroy', $course->id); ?>" method="POST" class="inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <!-- Formulario para Crear o Editar Curso -->
    <h2 class="text-2xl font-semibold mt-8 mb-4">
        <?php echo isset($_GET['edit']) ? 'Editar Curso' : 'Crear Nuevo Curso'; ?>
    </h2>
    <form action="<?php echo isset($_GET['edit']) ? route('courses.update', $_GET['edit']) : route('courses.store'); ?>"
          method="POST" class="bg-gray-100 p-6 rounded shadow-md">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       
        <?php if (isset($_GET['edit'])): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>


        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nombre del Curso</label>
            <?php
                $coursesArray = $courses->toArray();
                $editCourse = isset($_GET['edit']) ? $courses->firstWhere('id', $_GET['edit']) : null;
            ?>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo $editCourse ? htmlspecialchars($editCourse['name']) : ''; ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                required>
        </div>


        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Guardar'; ?>
        </button>
        <?php if (isset($_GET['edit'])): ?>
            <a href="<?php echo route('courses.index'); ?>" class="ml-2 text-gray-500 hover:underline">Cancelar</a>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
