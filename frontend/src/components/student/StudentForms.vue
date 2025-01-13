<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Mis Formularios</h2>
    <div v-for="form in forms" :key="form.id" class="bg-white rounded-lg shadow p-4 mb-4">
      <h3 class="text-lg font-semibold">{{ form.title }}</h3>
      <p class="text-sm text-gray-500">{{ form.description }}</p>
      <button @click="handleFormClick(form.id)" class="mt-4 bg-primary text-white px-4 py-2 rounded">
        Completar
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useFormsStore } from '@/stores/forms'; // Ruta correcta al store

const formsStore = useFormsStore();
const forms = ref([]);

// Cargar formularios al montar el componente
onMounted(async () => {
  try {
    await formsStore.loadForms();  // Llamamos al método para cargar los formularios
    forms.value = formsStore.forms;  // Asignamos los formularios al ref
  } catch (error) {
    console.error("Error al cargar formularios", error);
  }
});

// Manejador del clic en el formulario
const handleFormClick = (formId) => {
  // Redirigir al formulario específico para completar
  window.location.href = `/student/forms/${formId}`;  // Esto redirige a la página de formulario
};
</script>

