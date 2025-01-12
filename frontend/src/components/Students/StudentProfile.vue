<script setup>
import { useRoute } from 'vue-router'
import { useStudentsStore } from '@/stores/studentsStore'
import { onMounted, ref, computed } from 'vue'

const route = useRoute()
const studentsStore = useStudentsStore()

// Estado para el estudiante
const student = ref(null)
const isLoading = ref(true)
const error = ref(null)

// Obtener el ID del estudiante desde los parámetros de la ruta
const studentId = route.params.id

// Lógica para cargar el estudiante
onMounted(async () => {
  try {
    // Asegúrate de que los estudiantes estén cargados
    if (!studentsStore.students.length) {
      await studentsStore.fetchStudents()
    }

    // Recuperar al estudiante por su ID
    student.value = studentsStore.getStudentById(Number(studentId))

    if (!student.value) {
      error.value = 'Estudiante no encontrado'
    }
  } catch (err) {
    console.error(err)
    error.value = 'Error al cargar los estudiantes'
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
      <p class="mt-4 text-gray-500">Cargando perfil del estudiante...</p>
    </div>

    <!-- Mostrar error -->
    <div v-else-if="error" class="text-center py-8 text-red-500">
      {{ error }}
    </div>

    <!-- Mostrar los datos del estudiante -->
    <div v-else class="space-y-4">
      <div class="flex items-center space-x-4 mb-6">
        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-2xl">
          {{ student.name.split(' ').map(n => n[0]).join('').toUpperCase() }}
        </div>
        <h1 class="text-3xl font-bold">{{ student.name }}</h1>
      </div>
      <p class="text-lg"><strong>Curso:</strong> {{ student.course }}</p>
      <p class="text-lg"><strong>División:</strong> {{ student.division }}</p>
      <p class="text-lg"><strong>Email:</strong> {{ student.email }}</p>
    </div>
  </div>
</template>

