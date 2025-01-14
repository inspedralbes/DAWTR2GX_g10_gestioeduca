<script setup>
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import ProfileHeader from '../../StudentProfile/ProfileHeader.vue';
import Footer from '../../common/Footer.vue';

const groups = ref([]);
const isLoading = ref(true);
const router = useRouter();

const viewGroupsDetails = (id) => {
  router.push({ name: 'groupsProfile', params: { id } });
};

onMounted(async () => {
  try {
    const response = await fetch('/groups.json');
    if (!response.ok) throw new Error('Error al cargar los datos.');
    groups.value = await response.json();
    console.log("entran los datos")
  } catch (error) {
    console.error(error);
  } finally {
    isLoading.value = false;
  }
});

// Función para generar URL del avatar basado en el ID
const getAvatar = (id) => `https://api.dicebear.com/5.x/shapes/svg?seed=Group-${id}`;
</script>

<template>
  <!-- Indicador de carga -->
  <div v-if="isLoading" class="loading">
    <p>Carregant...</p>
  </div>

  <div v-else>
    <ProfileHeader /> <!-- Cabecera del perfil -->

    <div class="group-list-wrapper bg-white py-12 sm:py-16 w-full flex flex-col min-h-[calc(100vh-150px)]">
      <div class="mx-auto grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 px-6 lg:px-8">
        <div v-for="group in groups" :key="group.group_id" class="bg-gray-100 p-4 rounded-lg shadow-md">
          <!-- Tarjeta del estudiante -->
          <div class="flex flex-col items-center">
            <div class="card-container">
              <img :src="getAvatar(group.group_id)" alt="Avatar del grupo" class="avatar rounded-full" />
              <div class="text-center">
                <h3 class="text-base font-semibold text-gray-900">{{ group.description }}</h3>
                <p class="text-sm text-gray-600">{{ group.course }}</p>
                <button @click="viewGroupsDetails(group.group_id)"
                  class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                  Fitxa grup
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<style scoped>
.card-container {
  border: 2px solid #ccc;
  border-radius: 8px;
  width: 200px;
  height: 200px;
  padding: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.card-container:hover {
  transform: scale(1.05);
}

.group-list-wrapper {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  min-height: calc(100vh - 150px);
}

.avatar {
  width: 50%;
  max-width: 80px;
  height: 50%;
  object-fit: cover;
  margin-bottom: 8px;
}

.loading {
  text-align: center;
  font-size: 1.2rem;
  font-weight: bold;
  color: #555;
}
</style>
