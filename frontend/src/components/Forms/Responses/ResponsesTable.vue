<script setup>
import { computed } from 'vue'
import { format } from 'date-fns'
import { EyeIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  responses: {
    type: Array,
    required: true
  },
  selected: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['update:selected', 'view'])

const isAllSelected = computed(() => {
  return props.responses.length > 0 && props.selected.length === props.responses.length
})

const toggleSelectAll = () => {
  if (isAllSelected.value) {
    emit('update:selected', [])
  } else {
    emit('update:selected', props.responses.map(r => r.id))
  }
}

const toggleSelect = (responseId) => {
  const selected = new Set(props.selected)
  if (selected.has(responseId)) {
    selected.delete(responseId)
  } else {
    selected.add(responseId)
  }
  emit('update:selected', Array.from(selected))
}

const isSelected = (responseId) => props.selected.includes(responseId)
</script>

<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left">
              <input
                type="checkbox"
                :checked="isAllSelected"
                @change="toggleSelectAll"
                class="rounded text-primary focus:ring-primary"
              />
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
              Estudiante
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
              Curso
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
              Fecha
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
              Estado
            </th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr 
            v-for="response in responses" 
            :key="response.id"
            :class="{ 'bg-primary/5': isSelected(response.id) }"
          >
            <td class="px-6 py-4">
              <input
                type="checkbox"
                :checked="isSelected(response.id)"
                @change="toggleSelect(response.id)"
                class="rounded text-primary focus:ring-primary"
              />
            </td>
            <td class="px-6 py-4">
              <div class="text-sm font-medium text-gray-900">
                {{ response.studentName }}
              </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-500">
              {{ response.course }}
            </td>
            <td class="px-6 py-4 text-sm text-gray-500">
              {{ format(new Date(response.submittedAt), 'dd/MM/yyyy HH:mm') }}
            </td>
            <td class="px-6 py-4">
              <span 
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                :class="{
                  'bg-green-100 text-green-800': response.division === 'completed',
                  'bg-yellow-100 text-yellow-800': response.division === 'partial'
                }"
              >
                {{ response.division }}
              </span>
            </td>
            <td class="px-6 py-4 text-right space-x-3">
              <button
                class="text-gray-400 hover:text-primary"
                @click="$emit('view', response)"
              >
                <EyeIcon class="w-5 h-5" />
              </button>
              <button class="text-gray-400 hover:text-primary">
                <ChatBubbleLeftRightIcon class="w-5 h-5" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>