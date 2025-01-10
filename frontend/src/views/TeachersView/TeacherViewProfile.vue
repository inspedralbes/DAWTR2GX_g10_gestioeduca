<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import TeacherProfile from '@/components/Teachers/TeacherProfile.vue';
import { useTeachersStore } from '@/stores/teachersStore';

const route = useRoute();
const teachersStore = useTeachersStore();

// Estado para el profe encontrado, error y loading
const teacher = ref(null);
const isLoading = ref(true);
const error = ref('');
const id = Number(route.params.id); // Convierte el ID a número

// Usar onMounted para la carga inicial
onMounted(async () => {
  try {
    // Llamar a la API al montar el componente
    await teachersStore.fetchTeachers();

    // Verifica que los profes estén cargados
    console.log('profesores cargados:', teachersStore.teachers);

    if (!id) {
      console.error('No se pasó un ID de profesor en la URL');
      error.value = 'ID no proporcionado';
      return;
    }

    // Buscar el profesor por el ID
    teacher.value = teachersStore.getTeachersById(id);

    // Verificar si se encontró al profesor
    console.log('profesor encontrado:', teacher.value);

    if (!teacher.value) {
      console.error('Profesor no encontrado con ID:', id);
      error.value = 'Profesor no encontrado';
    }

  } catch (err) {
    console.error('Error al cargar los profesores:', err);
    error.value = 'Error al cargar los profesores';
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Perfil del Profesor</h1>
    </div>

    <!-- Mostrar cargando si la información está siendo obtenida -->
    <div v-if="isLoading" class="text-center py-8 text-gray-500">
      Cargando perfil...
    </div>

    <!-- Mostrar error si hay algún problema al encontrar el profe -->
    <div v-else-if="error" class="text-center py-8 text-red-500">
      {{ error }}
    </div>

    <!-- Mostrar el perfil del profe si se encontró -->
    <div v-if="teacher" class="space-y-6">
      <TeacherProfile :teacher="teacher" />
    </div>
  </div>
</template>
