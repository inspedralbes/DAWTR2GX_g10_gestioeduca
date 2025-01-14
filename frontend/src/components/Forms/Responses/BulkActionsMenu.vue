<script setup>
import { 
  ArrowDownTrayIcon,
  TrashIcon,
  ChatBubbleLeftRightIcon
} from '@heroicons/vue/24/outline'

defineProps({
  selectedCount: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['action'])
</script>

<template>
  <div v-if="selectedCount > 0" class="flex items-center space-x-3">
    <span class="text-sm text-gray-500">
      {{ selectedCount }} seleccionats
    </span>
    
    <button
      class="btn bg-white hover:bg-gray-50 text-gray-700 border flex items-center space-x-2"
      @click="$emit('action', 'export')"
    >
      <ArrowDownTrayIcon class="w-5 h-5" />
      <span>Exportar</span>
    </button>

    <button
      class="btn bg-white hover:bg-gray-50 text-gray-700 border flex items-center space-x-2"
      @click="$emit('action', 'comment')"
    >
      <ChatBubbleLeftRightIcon class="w-5 h-5" />
      <span>Comentar</span>
    </button>

    <button
      class="btn bg-danger/10 hover:bg-danger/20 text-danger flex items-center space-x-2"
      @click="$emit('action', 'delete')"
    >
      <TrashIcon class="w-5 h-5" />
      <span>Eliminar</span>
    </button>
  </div>
</template>