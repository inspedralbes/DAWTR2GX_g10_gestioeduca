<script setup>
import { DocumentTextIcon, ListBulletIcon, HashtagIcon, Square2StackIcon } from '@heroicons/vue/24/outline'
import { questionTypes } from './QuestionTypes'

const icons = {
  DocumentTextIcon,
  ListBulletIcon,
  HashtagIcon,
  CheckBoxIcon: Square2StackIcon
}

defineEmits(['select'])
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <button
      v-for="type in questionTypes"
      :key="type.id"
      class="flex items-start p-4 border rounded-lg hover:border-primary hover:bg-primary/5 transition-colors"
      @click="$emit('select', type.id)"
    >
      <component :is="icons[type.icon]" class="w-6 h-6 text-primary mr-3 flex-shrink-0" />
      <div class="text-left">
        <h3 class="font-medium">{{ type.label }}</h3>
        <p class="text-sm text-gray-500">{{ type.description }}</p>
      </div>
    </button>
  </div>
</template>