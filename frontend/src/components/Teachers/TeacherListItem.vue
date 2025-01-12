<script setup>
import { useRouter } from 'vue-router';
import { EyeIcon } from '@heroicons/vue/24/outline'; 
import { useTeachersStore } from '@/stores/teachersStore'
import { onMounted, computed } from 'vue'

// Obtener el enrutador
const router = useRouter();
const teachersStore = useTeachersStore()
onMounted(() => {
  // Llamar a la API al montar el componente
  teachersStore.fetchTeachers()
})
// Definir prop `teacher`
defineProps({
  teacher: {
    type: Object,
    required: true
  }
});

// Navegación al perfil del profesor
const viewProfile = (teacherId) => {
  if (teacherId) {
    router.push({ name: 'TeacherViewProfile', params: { id: teacherId } });
  } else {
    console.error("teacherId no está definido");
  }
};
</script>

<template>
  <!-- Fila de profesor -->
  <tr v-if="teacher" class="border-b hover:bg-gray-50" :key="teacher.id">
    <td class="py-4">
      <div class="flex items-center space-x-3">
        <!-- Iniciales -->
        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
          {{ teacher.name?.split(' ').map(n => n[0] || '').join('').toUpperCase() || 'N/A' }}
        </div>
        <span>{{ teacher.name }}</span>
      </div>
    </td>
    <!-- Información del profesor -->
    <td>{{ teacher.course }}</td>
    <td>{{ teacher.division }}</td>

    <!-- Botón para ver el perfil -->
    <td>
      <div class="flex space-x-2">
        <button class="p-1 hover:text-primary" @click.stop="viewProfile(teacher.id)">
          <EyeIcon class="w-5 h-5" />
        </button>
      </div>
    </td>
  </tr>
</template>
