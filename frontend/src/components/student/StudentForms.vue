<script setup>
import { ref, onMounted } from 'vue';

const formsData = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/forms', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json',
      }
    });
    
    if (!response.ok) throw new Error('Error al cargar los formularios');
    formsData.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Formularios</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="form in formsData" :key="form.id" 
        class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-2">{{ form.title }}</h3>
        <p class="text-gray-600 mb-4">{{ form.description }}</p>
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-500">Fecha límite: {{ form.due_date }}</span>
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
