<script setup>
import { ref, onMounted } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline'
import StudentListComponent from '../../components/Students/StudentList.vue'
import StudentFilters from '../../components/Students/StudentFilters.vue'
import { useStudentSearch } from '../../composables/useStudentSearch'

const students = ref([])
onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/users', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json',
      }
    });
    
    if (!response.ok) throw new Error('Error al cargar los formularios');
    students.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});

const {
  searchQuery,
  selectedGrade,
  selectedStatus,
  filteredStudents
} = useStudentSearch(students)
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Alumnos</h1>
      <button class="btn btn-primary flex items-center space-x-2">
        <PlusIcon class="w-5 h-5" />
        <span>Nuevo Alumno</span>
      </button>
    </div>

    <StudentFilters
      v-model:searchQuery="searchQuery"
      v-model:selectedGrade="selectedGrade"
      v-model:selectedStatus="selectedStatus"
    />

    <StudentListComponent :students="filteredStudents" />
  </div>
</template>