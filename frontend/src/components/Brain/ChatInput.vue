<script setup>
import { ref } from 'vue';

const emit = defineEmits(['send']);
const props = defineProps({
  isLoading: Boolean
});

const input = ref('');

const handleSubmit = () => {
  if (!input.value.trim() || props.isLoading) return;
  emit('send', input.value);
  input.value = '';
};
</script>

<template>
  <div class="flex items-center space-x-4">
    <input
      v-model="input"
      type="text"
      placeholder="Escriu el teu missatge..."
      class="flex-1 p-4 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
      @keyup.enter="handleSubmit"
    />
    <button
      @click="handleSubmit"
      :disabled="isLoading"
      class="p-4 rounded-full bg-primary text-white hover:bg-opacity-90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
      </svg>
    </button>
  </div>
</template>