<script setup>
import TeacherListItem from './TeacherListItem.vue';
import { useTeachersStore } from '@/stores/teachersStore';
import { onMounted, computed  } from 'vue';

// Usar el store
const teachersStore = useTeachersStore();
// Llamar a la API al montar el componente
onMounted(() => {
  teachersStore.fetchTeachers();
});
defineProps({
  teachers: {
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
          <!-- Iterar sobre 'teachers' -->
          <TeacherListItem
            v-for="teacher in teachers"
            :key="teacher.id"
            :teacher="teacher"
          />
        </tbody>
      </table>
    </div>

    <!-- Mostrar mensaje si la lista está vacía -->
    <div v-if="teachers.length === 0" class="text-center py-8 text-gray-500">
      No se encontraron profesores con los filtros seleccionados
    </div>
  </div>
</template>
