<script setup>
import { useRoute } from 'vue-router'
import { useTeachersStore } from '@/stores/teachersStore';
import { onMounted, ref, computed } from 'vue'

const route = useRoute()
const teachersStore = useTeachersStore()
// Estado para el teacher
const teacher = ref(null)
const isLoading = ref(true)
const error = ref(null)

// Obtener el ID del teacher desde los parámetros de la ruta
const teacherId = route.params.id

// Lógica para cargar el teacher
onMounted(async () => {
  try {
    if (!teachersStore.teachers.length) {
      await teachersStore.fetchTeachers()
    }

    // Recuperar al user por su ID
    teacher.value = teachersStore.getTeachersById(Number(teacherId))

    if (!teacher.value) {
      error.value = 'Profesor no encontrado'
    }
  } catch (err) {
    console.error(err)
    error.value = 'Error al cargar los profesores'
  } finally {
    isLoading.value = false
  }
})
</script>


<template>
  <div class="p-6">
    <!-- Loading Spinner -->
    <div v-if="isLoading" class="text-center py-8">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
      <p class="mt-4 text-gray-500">Cargando perfil del Profesor...</p>
    </div>

    <!-- Mostrar error -->
    <div v-else-if="error" class="text-center py-8 text-red-500">
      {{ error }}
    </div>

    <!-- Mostrar los datos del profesor -->
    <div v-else class="space-y-4">
      <div class="flex items-center space-x-4 mb-6">
        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-2xl">
          {{ teacher.name.split(' ').map(n => n[0]).join('').toUpperCase() }}
        </div>
        <h1 class="text-3xl font-bold">{{ teacher.name }}</h1>
        <h1 class="text-3xl font-bold">{{ teacher.last_name }}</h1>
      </div>
      <p class="text-lg"><strong>Curso:</strong> {{ teacher.course }}</p>
      <p class="text-lg"><strong>División:</strong> {{ teacher.division }}</p>
      <p class="text-lg"><strong>Email:</strong> {{ teacher.email }}</p>
    </div>
  </div>
</template>

