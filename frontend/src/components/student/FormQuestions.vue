<template>
    <div class="space-y-6 p-6">
      <!-- Título del formulario -->
      <h2 class="text-2xl font-bold">Formulari: {{ formId }}</h2>
      
      <!-- Mostrar las preguntas del formulario -->
      <div v-for="(question, index) in questions" :key="question.id" class="space-y-4">
        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-semibold">{{ question.title }}</h3>
          <p class="text-sm text-gray-500">{{ question.placeholder }}</p>
  
          <!-- Manejo de diferentes tipos de preguntas -->
          <div v-if="question.type === 'text'">
            <input
              type="text"
              class="mt-2 p-2 border rounded w-full"
              :placeholder="question.placeholder"
            />
          </div>
  
          <div v-if="question.type === 'multiple'">
            <div v-for="option in question.options" :key="option.id" class="mt-2">
              <label class="flex items-center">
                <input
                  type="radio"
                  :name="'question-' + question.id"
                  :value="option.id"
                  class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500"
                />
                <span class="ml-2 text-gray-700">{{ option.text }}</span>
              </label>
            </div>
          </div>
  
          <div v-if="question.type === 'checkbox'">
            <div v-for="option in question.options" :key="option.id" class="mt-2">
              <label class="flex items-center">
                <input
                  type="checkbox"
                  :name="'question-' + question.id"
                  :value="option.id"
                  class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500"
                />
                <span class="ml-2 text-gray-700">{{ option.text }}</span>
              </label>
            </div>
          </div>
  
          <div v-if="question.type === 'number'">
            <input
              type="number"
              class="mt-2 p-2 border rounded w-full"
              :placeholder="question.placeholder"
            />
          </div>
  
          <!-- Mostrar respuestas de la pregunta -->
          <div v-if="question.answers && question.answers.length > 0" class="mt-4">
            <h4 class="text-lg font-semibold text-gray-800">Respostes:</h4>
            <div class="space-y-2 mt-2">
              <div v-for="answer in question.answers" :key="answer.id" class="p-2 bg-gray-100 rounded-lg">
                <div class="text-gray-700">
                  <strong>Resposta:</strong> {{ answer.answer }}
                </div>
                <div class="text-sm text-gray-500 mt-1">
                  <strong>Usuari:</strong> {{ answer.user_name || 'Desconocido' }}
                </div>
              </div>
            </div>
          </div>
  
          <!-- Si no hay respuestas -->
          <div v-else class="mt-2 text-sm text-gray-500">
            No hay respuestas disponibles para esta pregunta.
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import { useFormsStore } from '@/stores/forms';  // Asegúrate de que la ruta es correcta
  
  const formsStore = useFormsStore();
  const route = useRoute();
  const formId = route.params.id;  // Obtenemos el ID del formulario desde la ruta
  const questions = ref([]);
  
  // Cargar preguntas del formulario cuando el componente se monte
  onMounted(async () => {
    try {
      const form = await formsStore.loadFormById(formId);  // Cargamos el formulario por ID
      if (form) {
        questions.value = form.questions;  // Asumimos que la respuesta tiene un campo 'questions'
      }
    } catch (error) {
      console.error('Error al cargar las preguntas:', error);
    }
  });
  </script>
  
  <style scoped>
  /* Estilos adicionales si es necesario */
  </style>
  