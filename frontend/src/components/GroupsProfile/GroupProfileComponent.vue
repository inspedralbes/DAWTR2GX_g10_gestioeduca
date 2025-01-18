<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Footer from '../common/Footer.vue';
import ProfileHeader from '../StudentProfile/ProfileHeader.vue';

const route = useRoute();
const group = ref(null);
const isLoading = ref(true);
const error = ref(null);

// Cargar los datos del grupo y sus estudiantes cuando se haga clic
onMounted(async () => {
  try {
    const response = await fetch('/groups.json'); 
    if (!response.ok) throw new Error('Error al cargar los datos del grupo.');
    const groups = await response.json();
    
    // Obtener el ID del grupo desde la URL
    const groupId = parseInt(route.params.id);  
    group.value = groups.find(g => g.group_id === groupId);

    
    if (!group.value) {
      error.value = `Grupo con ID ${groupId} no encontrado.`;
    }
  } catch (err) {
    console.error(err);
    error.value = "Hubo un problema al cargar los datos del grupo.";
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <!-- Indicador de carga -->
  <div v-if="isLoading" class="loading">
    <p>Carregant...</p>
  </div>

  <!-- Mensaje de error si hay un problema -->
  <div v-if="error" class="error-message text-center text-red-500 font-semibold mt-4">
    <p>{{ error }}</p>
  </div>

  <!-- Mostrar detalles del grupo si se carga correctamente -->
  <div v-else-if="group" class="group-profile-wrapper">
    <ProfileHeader />

    <div class="group-details bg-white pt-24">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Detalles del grupo -->
        <div class="text-center">
          <h2 class="text-3xl font-semibold tracking-tight text-gray-900">{{ group.description }}</h2>
          <p class="mt-4 text-lg text-gray-600">{{ group.course }}</p>
        </div>

        <!-- Lista de estudiantes -->
        <div class="student-list mt-8">
          <h3 class="text-2xl font-semibold text-gray-900">Estudiants del grup</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-6">
            <div v-for="student in group.students" :key="student.student_id" class="student-card bg-gray-100 p-4 rounded-lg shadow-md">
              <div class="flex flex-col items-center text-center">
                <!-- Avatar del estudiante con iniciales -->
                <div class="avatar w-24 h-24 bg-blue-500 text-white text-2xl font-bold rounded-full flex items-center justify-center mb-4">
                  {{ student.name[0] }}{{ student.surname[0] }}
                </div>
                <h4 class="text-lg font-semibold text-gray-900">{{ student.name }} {{ student.surname }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>

  <div v-else class="text-center">
    <p>No s'ha trobat el grup amb ID {{ route.params.id }}.</p>
  </div>
</template>

<style scoped>
.group-profile-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
  background-color: #f8f9fa;
}

.group-details {
  flex: 1;
  padding: 30px;
}

.student-list {
  margin-top: 20px;
}

.student-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 16px;
  background-color: #f7fafc;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.avatar {
  width: 80px;
  height: 80px;
  font-size: 1.5rem;
}

.loading {
  text-align: center;
  font-size: 1.2rem;
  font-weight: bold;
  color: #555;
}

.error-message {
  text-align: center;
  font-size: 1.2rem;
  font-weight: bold;
  color: red;
}

</style>
