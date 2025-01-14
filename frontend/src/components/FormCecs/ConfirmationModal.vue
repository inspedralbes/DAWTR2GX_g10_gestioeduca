<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Confirmación de Envío</h2>
        
        <div class="mb-4">
          <p class="text-gray-700">Heu completat totes les preguntes del qüestionari.</p>
          <div class="mt-4 bg-blue-50 p-4 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">Resumen</h3>
            <ul class="list-disc list-inside text-sm">
              <li>Nom: {{ studentInfo.name }}</li>
              <li>Curs: {{ studentInfo.course }}</li>
              <li>Centre: {{ studentInfo.school }}</li>
              <li>Preguntes respostes: {{ totalQuestions }}/{{ totalQuestions }}</li>
            </ul>
          </div>
        </div>
        
        <p class="text-gray-600 mb-4">Estàs segur que vols enviar el formulari?</p>
        
        <div class="flex justify-between">
          <button 
            @click="$emit('cancel')"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-full"
          >
            Revisar
          </button>
          <button 
            @click="$emit('confirm')"
            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full"
          >
            Enviar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    studentInfo: {
      type: Object,
      required: true
    },
    totalQuestions: {
      type: Number,
      required: true
    }
  })
  
  defineEmits(['confirm', 'cancel'])
  </script>