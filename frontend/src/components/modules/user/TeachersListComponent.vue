<script setup>
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import ProfileHeader from '../../StudentProfile/ProfileHeader.vue';
import Footer from '../../common/Footer.vue';
import { useTeachersStore } from '@/stores/teachersStore';

const teachersStore = useTeachersStore();
const isLoading = ref(true);
const router = useRouter();
const teachers = ref([]);

// Cargar los datos de profesores
onMounted(async () => {
  try {
    await teachersStore.fetchTeachers();
    teachers.value = teachersStore.teachers; // Obtener los datos del store
  } catch (error) {
    console.error('Error cargando profesores:', error);
  } finally {
    isLoading.value = false;
  }
});

// Función para redirigir al perfil del profesor
const viewTeacherDetails = (id) => {
  router.push({ name: 'teacherProfile', params: { id } });
};

// Obtener iniciales del nombre y apellido
const getInitials = (name) => {
  if (!name) return '';
  return `${name[0]}`.toUpperCase();
};
</script>

<template>
  <!-- Indicador de carga -->
  <div v-if="isLoading" class="loading">
    <p>Carregant...</p>
  </div>

  <div v-else class="flex flex-col min-h-screen">
    <!-- Cabecera del perfil -->
    <ProfileHeader />

    <!-- Lista de profesores -->
    <div class="teacher-list-wrapper bg-white flex-grow py-12 sm:py-16">
      <div class="mx-auto grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 px-6 lg:px-8">
        <div
          v-for="teacher in teachers"
          :key="teacher.id"
          class="bg-gray-100 p-4 rounded-lg shadow-md"
        >
          <!-- Tarjeta del profesor -->
          <div class="flex flex-col items-center">
            <div class="card-container">
              <div
                class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white text-lg font-semibold rounded-full"
              >
                {{ getInitials(teacher.name) }}
              </div>
              <div class="text-center">
                <h3 class="text-base font-semibold text-gray-900">
                  {{ teacher.name }}
                </h3>
                <p class="text-sm text-gray-600">{{ teacher.email }}</p>
                <button
                  @click="viewTeacherDetails(teacher.id)"
                  class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                  Fitxa Professor/a
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pie de página -->
    <Footer />
  </div>
</template>
