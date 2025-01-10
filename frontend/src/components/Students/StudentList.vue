<script setup>
import StudentListItem from './StudentListItem.vue';
import { useStudentsStore } from '@/stores/studentsStore'
import { onMounted, computed } from 'vue';

// Usar store
const studentsStore = useStudentsStore()

// Llamar a la API al montar el componente
onMounted(() => {
  studentsStore.fetchStudents()
})

// Declara la prop 'student' en este componente
defineProps({
  students: {
    type: Object,
    required: true
  }
})

</script>

<template>
  <div class="card">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b">
            <th class="text-left py-3">Nombre</th>
            <th class="text-left py-3">Curso</th>
            <th class="text-left py-3">Clase</th>
            <th class="text-left py-3">Ficha</th>
          </tr>
        </thead>
        <tbody>
          <StudentListItem
            v-for="student in students"
            :key="student.id"
            :student="student"
          />
        </tbody>
      </table>
    </div>
    <div v-if="students.length === 0" class="text-center py-8 text-gray-500">
      No se encontraron estudiantes con los filtros seleccionados
    </div>
  </div>
</template>
