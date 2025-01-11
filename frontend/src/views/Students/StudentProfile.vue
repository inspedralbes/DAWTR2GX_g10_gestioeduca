<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import StudentProfile from '../../components/Students/StudentProfile/StudentProfile.vue'
import FormAssignments from '../../components/Students/StudentProfile/FormAssignments.vue'

const route = useRoute()
const student = ref(null)
const studentId = ref(Number(route.params.id))
const formAssignments = ref([])

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/forms', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json',
      }
    });
    
    if (!response.ok) throw new Error('Error al cargar los formularios');
    formAssignments.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});

onMounted(async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/users/${studentId.value}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json',
      }
    });
    
    if (!response.ok) throw new Error('Error al cargar los usuarios');
    student.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Perfil del Estudiante</h1>
    </div>

    <div v-if="student" class="space-y-6">
      <StudentProfile :student="student" />
      <FormAssignments :assignments="formAssignments" />
    </div>
    <div v-else class="text-center py-8 text-gray-500">
      Cargando perfil...
    </div>
  </div>
</template>