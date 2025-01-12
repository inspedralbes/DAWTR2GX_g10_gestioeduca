<script setup>
import { ref, onMounted, computed } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline'
import StudentListComponent from '../../components/Students/StudentList.vue'
import StudentFilters from '../../components/Students/StudentFilters.vue'
import { useStudentSearch } from '../../composables/useStudentSearch'
import { useStudentsStore } from '@/stores/studentsStore'

const studentsStore = useStudentsStore()
const isLoading = ref(true)
// Llamar a la API al montar el componente
onMounted(async () => {
  await studentsStore.fetchStudents() // Esperar a que los datos se carguen
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
console.log(filteredStudents.value)

</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Alumnos</h1>
    </div>
    <div v-if="isLoading" class="text-center p-8">
      Cargando estudiantes...
    </div>
    <div v-else>
    <StudentFilters 
      v-model:searchQuery="searchQuery"
      v-model:selectedCourse="selectedCourse"
      v-model:selectedDivision="selectedDivision"
    />
    <StudentListComponent :students="filteredStudents" />
  </div>
  </div>
</template>