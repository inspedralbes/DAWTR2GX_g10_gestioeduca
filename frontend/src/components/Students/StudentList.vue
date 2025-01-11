<script setup>
import StudentListItem from './StudentListItem.vue';

defineProps({
  students: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <div class="card">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b">
            <th class="text-left py-3">Nombre</th>
            <th class="text-left py-3">Curso</th>
            <th class="text-left py-3">Asistencia</th>
            <th class="text-left py-3">Rendimiento</th>
            <th class="text-left py-3">Estado</th>
            <th class="text-left py-3">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <StudentListItem
            v-for="student in students.filter(f => f.role_id === 2)" :key="student.id_student"
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