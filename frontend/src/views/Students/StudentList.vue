<script setup>
import { ref, onMounted, computed } from 'vue'
import StudentList from '../../components/Students/StudentList.vue'
import StudentFilters from '../../components/Students/StudentFilters.vue'
import { useStudentSearch } from '../../composables/useStudentSearch'
import { useStudentsStore } from '@/stores/studentsStore'
import { useRouter } from 'vue-router'

const studentsStore = useStudentsStore()
const isLoading = ref(true)
const router = useRouter()

// Llamar a la API al montar el componente
onMounted(async () => {
  await studentsStore.fetchStudents()
  isLoading.value = false
})

// Utilizar computed para asegurar que reaccionen cambios en el estado
const students = computed(() => studentsStore.students || [])
const {
  searchQuery,
  selectedCourse,
  selectedDivision,
  filteredStudents
} = useStudentSearch(students)

// Método para navegar al dashboard
const goToDashboard = () => {
  router.push('/dashboard')
}

</script>

<template>
  <div class="p-6">
    <div class="relative flex items-center mb-6">
      <!-- Botón de volver -->
      <button 
        @click="goToDashboard" 
        class="absolute left-0 flex items-center space-x-1 text-gray-700 hover:text-gray-900"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Tornar</span>
      </button>

      <!-- Título centrado -->
      <h1 class="flex-grow text-center text-2xl font-bold">Gestión de Alumnos</h1>
    </div>
    <div v-if="isLoading" class="text-center p-8">
      Carregant estudiants...
    </div>
    <div v-else>
      <StudentFilters 
        v-model:searchQuery="searchQuery"
        v-model:selectedCourse="selectedCourse"
        v-model:selectedDivision="selectedDivision"
      />
      <StudentList :students="filteredStudents" />
    </div>
  </div>
</template>

