<script setup>
import { ref } from 'vue'

const activeTab = ref('chat')
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Comunicació</h1>

    <div class="bg-white rounded-lg shadow">
      <div class="border-b px-4">
        <nav class="flex space-x-8">
          <button
            v-for="tab in ['chat', 'departamento', 'recursos']"
            :key="tab"
            @click="activeTab = tab"
            class="py-4 px-1 border-b-2 font-medium text-sm"
            :class="activeTab === tab ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700'"
          >
            {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
          </button>
        </nav>
      </div>

      <div class="p-4">
        <p class="text-gray-500">Contingut de {{ activeTab }}</p>
      </div>
    </div>
  </div>
</template>