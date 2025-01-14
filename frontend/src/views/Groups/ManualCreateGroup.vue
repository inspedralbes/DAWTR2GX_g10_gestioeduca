<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useStudentsStore } from "@/stores/studentsStore";

// Router para manejar redirecciones
const router = useRouter();

// Almacén para manejar estudiantes
const studentsStore = useStudentsStore();

// Selecciones de estudiantes
const selectedStudents = ref([]);

// Llamar a la API para obtener los estudiantes
onMounted(() => {
    studentsStore.fetchStudents();
});

// Computed: Lista de estudiantes desde el almacén
const students = computed(() => studentsStore.students);

// Manejar selección de estudiantes
const toggleSelection = (studentId) => {
    if (selectedStudents.value.includes(studentId)) {
        // Eliminar si ya está seleccionado
        selectedStudents.value = selectedStudents.value.filter(id => id !== studentId);
    } else {
        // Agregar a la selección
        selectedStudents.value.push(studentId);
    }
};

// Crear grupo y enviarlo al backend
const groupName = ref("");
const groupDescription = ref("");
const errorMessage = ref("");

const handleCreateGroup = async () => {
    // Filtrar estudiantes seleccionados
    const selectedStudentsDetails = students.value.filter(student =>
        selectedStudents.value.includes(student.id)
    );

    // Datos para enviar al backend
    const groupData = {
        name: groupName.value,
        description: groupDescription.value,
        number_of_students: selectedStudentsDetails.length,
        
    };

    try {
        // Realizar POST al backend
        const response = await fetch("/api/groups", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(groupData),
        });

        if (!response.ok) {
            throw new Error("No se pudo crear el grupo");
        }

        const data = await response.json();
        console.log("Grupo creado:", data);

        // Redirigir a otra página o limpiar el formulario
        router.push("/Dashboard");
    } catch (error) {
        console.error(error);
        errorMessage.value = "Hubo un problema al crear el grupo. Intenta de nuevo.";
    }
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Seleccionar Alumnos para el Grupo</h1>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nombre del Grupo</label>
            <input
                v-model="groupName"
                type="text"
                placeholder="Ingrese el nombre del grupo"
                class="input w-full"
            />
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Descripción del Grupo</label>
            <textarea
                v-model="groupDescription"
                placeholder="Ingrese una descripción (opcional)"
                class="input w-full"
                rows="4"
            ></textarea>
        </div>
        <div>
            <h2 class="text-lg font-medium mb-2">Selecciona los Estudiantes:</h2>
            <ul class="divide-y divide-gray-200">
                <li
                    v-for="student in students"
                    :key="student.id"
                    class="py-4 flex items-center justify-between"
                >
                    <div>
                        <h2 class="text-lg font-medium">{{ student.name }} {{ student.last_name }}</h2>
                        <p class="text-sm text-gray-500">
                        </p>
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            :value="student.id"
                            :checked="selectedStudents.includes(student.id)"
                            @change="toggleSelection(student.id)"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        />
                    </div>
                </li>
            </ul>
        </div>

        <button
            class="mt-6 btn btn-primary w-full sm:w-auto"
            :disabled="!groupName || selectedStudents.length === 0"
            @click="handleCreateGroup"
        >
            Crear Grupo
        </button>

        <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
    </div>
</template>
