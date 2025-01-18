<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import ProfileHeader from './ProfileHeader.vue';
import ProfileSubjects from './ProfileSubjects.vue';
import Footer from '../common/Footer.vue';

const route = useRoute();
const teacher = ref(null);
const isLoading = ref(true);

// Cargar los datos del profesor solo cuando se hace clic
onMounted(async () => {
  try {
    const response = await fetch('/teachers.json');
    if (!response.ok) throw new Error('Error al cargar los datos.');
    const teachers = await response.json();

    // Obtener el ID de la URL y buscar el profesor correspondiente
    const teacherId = route.params.id;
    teacher.value = teachers.find(t => t.id_teacher === teacherId);
  } catch (error) {
    console.error(error);
  } finally {
    isLoading.value = false;
  }
});

// Función para obtener iniciales del nombre y apellido
const getInitials = (name, surname) => {
  if (!name || !surname) return '';
  return `${name[0]}${surname[0]}`.toUpperCase();
};
</script>

<template>
  <!-- Indicador de carga -->
  <div v-if="isLoading" class="loading">
    <p>Carregant...</p>
  </div>

  <div v-else class="teacher-profile-wrapper">
    <ProfileHeader :teacherName="teacher?.name" :teacherTagline="'Enseñando con pasión y compromiso'" />

    <div class="teacher-details bg-white pt-24">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div v-if="teacher" class="flex flex-col items-center text-center">
          <div class="w-24 h-24 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold">
            {{ getInitials(teacher.name, teacher.surname) }}
          </div>

          <!-- Nombre y Apellidos -->
          <h3 class="mt-6 text-3xl font-semibold tracking-tight text-gray-900">{{ teacher.name }} {{ teacher.surname }}</h3>
          <p class="mt-4 text-lg font-semibold text-indigo-600">{{ teacher.email }}</p>
          
        </div>
      </div>
    </div>

    <ProfileSubjects :educationList="teacher?.education" />
    <Footer />
  </div>
</template>

<style scoped>
.teacher-profile-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
  background-color: #f8f9fa;
}

.teacher-profile {
  flex: 1;
  width: 100%;
  background-color: #ffffff;
  padding: 30px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow-y: auto;
}

.teacher-details h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.teacher-details p {
  font-size: 1rem;
}

/* Estilo para la imagen con las iniciales */
.teacher-details .w-24 {
  width: 6rem;
  height: 6rem;
  font-size: 2rem;
}
</style>
