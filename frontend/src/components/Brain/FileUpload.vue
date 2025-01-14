<script setup>
import { ref } from 'vue';

const emit = defineEmits(['file-content']);

const supportedTypes = [
  'text/plain',
  'application/json',
  'text/csv',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

const handleFileUpload = async (event) => {
  const file = event.target.files[0];
  
  if (!file) {
    alert('Seleccioneu un fitxer');
    return;
  }

  // For doc/docx files, we'll need to handle them as binary
  if (file.type.includes('word')) {
    alert('Els documents de Word encara no són compatibles. Feu servir fitxers txt, json o csv.');
    return;
  }

  if (!supportedTypes.includes(file.type)) {
    alert('Pengeu un tipus de fitxer compatible (txt, json, csv)');
    return;
  }

  const reader = new FileReader();
  
  reader.onload = (e) => {
    try {
      const content = e.target.result;
      emit('file-content', content);
    } catch (error) {
      console.error('Error llegint el fitxer:', error);
      alert('Error al llegir el fitxer. Si us plau, torna-ho a provar.');
    }
  };

  reader.onerror = () => {
    alert('Error al llegir el fitxer. Si us plau, torna-ho a provar.');
  };

  reader.readAsText(file);
};
</script>

<template>
  <div class="w-full">
    <label class="block mb-2 text-sm font-medium text-gray-900">
      Carrega el document
    </label>
    <input
      type="file"
      @change="handleFileUpload"
      accept=".txt,.json,.csv"
      class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2"
    />
    <p class="mt-1 text-sm text-gray-500">
      Fitxers compatibles: TXT, JSON, CSV
    </p>
  </div>
</template>