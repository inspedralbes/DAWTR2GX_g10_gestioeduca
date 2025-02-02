<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Mis Formularios</h2>
    <div v-if="forms.length === 0" class="text-gray-500">
      No tienes formularios asignados.
    </div>
    <div v-else>
      <div v-for="form in forms" :key="form.id" class="bg-white rounded-lg shadow p-4 mb-4">
        <h3 class="text-lg font-semibold">{{ form.title }}</h3>
        <p class="text-sm text-gray-500">{{ form.description }}</p>
        
        <!-- Condicional para cambiar texto, color y deshabilitar el botón -->
        <button 
          @click="handleFormClick(form.id)" 
          :disabled="form.answered === 1" 
          :class="form.answered === 1 ? 'bg-green-300' : 'bg-primary text-white'" 
          class="mt-4 px-4 py-2 rounded"
        >
          {{ form.answered === 1 ? 'Completado' : 'Completar' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';  

const authStore = useAuthStore();
const forms = ref([]);
const user = authStore.user;  // Asegúrate de que el user_id esté almacenado en localStorage o donde sea pertinente.
const userId = user.id;

// Cargar formularios del usuario al montar el componente
const loadFormsByUserId = async (userId) => {
  try {
    const response = await fetch(`http://grupify.daw.inspedralbes.cat/backend/public/api/forms/user/${userId}`, {
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
    console.error("Error al cargar formularios", error);
  }
};

// Cargar los formularios cuando el componente se monta
onMounted(() => {
  loadFormsByUserId(userId);
});

// Manejador del clic en el formulario
const handleFormClick = (formId) => {
  if (formId === 2) {
    window.location.href = `/formCecs/${formId}`;  // Redirige a la ruta /formCecs si el formId es 2
  } else if (formId === 3) {
    window.location.href = '/sociogram';  // Redirige a /sociogram si el formId es 3
  } else {
    window.location.href = `/student/forms/${formId}`;  // Redirige a la ruta correspondiente para cualquier otro formId
  }
};

</script>
