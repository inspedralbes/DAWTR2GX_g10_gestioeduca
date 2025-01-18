<script setup>
import { computed } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  image: {
    type: String,
    default: ''
  }
})

const initials = computed(() => {
  return props.name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
})
</script>

<template>
  <div class="relative">
    <img
      v-if="image"
      :src="image"
      :alt="name"
      class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
    />
    <div
      v-else
      class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl font-bold border-4 border-white shadow-lg"
    >
      {{ initials }}
    </div>
  </div>
</template>