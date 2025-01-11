<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Formularios</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="form in forms" :key="form.id" 
        class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-2">{{ form.title }}</h3>
        <p class="text-gray-600 mb-4">{{ forms.description }}</p>
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-500">Fecha límite: {{ form.dueDate }}</span>
          <button 
            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90"
            @click="handleFormClick(form.id)">
            Completar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router' 

const router = useRouter() 

const forms = ref([]);

  onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/forms', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Error obteniendo los datos.');
    }

    forms.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});
const handleFormClick = (formId) => {
  if (formId === 4) {
    // Redirigir al formulario CESC
    router.push({ name: 'formCecs' })
  } else if (formId === 5) {
    // Redirigir al formulario Sociograma
    router.push({ name: 'sociogramTest' })
  } else {
    console.log(`Formulario con ID ${formId} no tiene una ruta específica.`)
  }
}
</script>