<script setup>
import { ref } from 'vue';
import FileUpload from './FileUpload.vue';

const emit = defineEmits(['file-content']);
const showUploadModal = ref(false);

const handleFileContent = (content) => {
  emit('file-content', content);
  showUploadModal.value = false;
};
</script>

<template>
  <div class="relative">
    <button
      @click="showUploadModal = true"
      class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
      <span class="text-sm text-gray-600">Carrega el fitxer</span>
    </button>

    <div v-if="showUploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Carrega el fitxer</h3>
          <button @click="showUploadModal = false" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <FileUpload @file-content="handleFileContent" />
      </div>
    </div>
  </div>
</template>