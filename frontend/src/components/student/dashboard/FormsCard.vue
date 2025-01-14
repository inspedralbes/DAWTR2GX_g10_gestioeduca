<template>
  <div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-xl font-semibold mb-6 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      Formularios Pendientes
    </h3>
    <div class="space-y-4">
      <div v-if="forms.length === 0" class="text-center text-gray-500">
        No tienes formularios asignados.
      </div>
      <div v-else>
        <div v-for="form in forms" :key="form.id"
          class="p-4 bg-gray-50 rounded-lg hover:bg-primary/5 transition-all cursor-pointer">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="font-semibold text-gray-900">{{ form.title }}</h4>
              <p class="text-sm text-gray-500">{{ form.description }}</p>
            </div>
            <span class="px-3 py-1 text-xs font-medium rounded-full" :class="form.urgencyColor">
              {{ form.urgency }}
            </span>
          </div>
          <div class="mt-3 flex justify-between items-center">
            <button @click="handleFormClick(form.id)" class="mt-4 bg-primary text-white px-4 py-2 rounded">
              Completar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const forms = ref([]);
const user = authStore.user;
const userId = user.id;

const loadFormsByUserId = async (userId) => {
  try {
    const response = await fetch(`http://pruebag10.daw.inspedralbes.cat/backend/public/api/forms/user/${userId}`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Error obteniendo los formularios del usuario.');
    }

    forms.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
};

onMounted(() => {
  loadFormsByUserId(userId);
});

const handleFormClick = (formId) => {
  // Redirigir al formulario específico para completar
  window.location.href = `/student/forms/${formId}`;  // Esto redirige a la página de formulario
};
</script>
