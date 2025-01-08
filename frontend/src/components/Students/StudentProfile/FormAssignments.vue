<script setup>
import { computed } from 'vue'
import { ClockIcon, CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  assignments: {
    type: Array,
    required: true
  }
})

const statusIcons = {
  pending: ClockIcon,
  completed: CheckCircleIcon,
  expired: XCircleIcon
}

const statusClasses = {
  pending: 'text-warning bg-warning/10',
  completed: 'text-success bg-success/10',
  expired: 'text-danger bg-danger/10'
}

const statusLabels = {
  pending: 'Pendiente',
  completed: 'Completado',
  expired: 'Expirado'
}

const sortedAssignments = computed(() => {
  return [...props.assignments].sort((a, b) => {
    if (a.status === 'pending' && b.status !== 'pending') return -1
    if (b.status === 'pending' && a.status !== 'pending') return 1
    return new Date(b.assignedDate) - new Date(a.assignedDate)
  })
})
</script>

<template>
  <div class="bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-lg font-medium text-gray-900">Formularios Asignados</h3>
      <button class="btn btn-primary">Asignar Nuevo</button>
    </div>

    <div class="space-y-4">
      <div
        v-for="assignment in sortedAssignments"
        :key="assignment.id"
        class="flex items-center justify-between p-4 border rounded-lg hover:border-primary/30 transition-colors"
      >
        <div class="flex-1">
          <h4 class="font-medium text-gray-900">{{ assignment.formTitle }}</h4>
          <p class="text-sm text-gray-500">
            Asignado: {{ new Date(assignment.assignedDate).toLocaleDateString() }}
          </p>
          <p v-if="assignment.dueDate" class="text-sm text-gray-500">
            Fecha límite: {{ new Date(assignment.dueDate).toLocaleDateString() }}
          </p>
        </div>

        <div class="flex items-center space-x-4">
          <span
            class="px-3 py-1 rounded-full text-sm flex items-center space-x-1"
            :class="statusClasses[assignment.status]"
          >
            <component :is="statusIcons[assignment.status]" class="w-4 h-4" />
            <span>{{ statusLabels[assignment.status] }}</span>
          </span>
          
          <button
            v-if="assignment.status === 'pending'"
            class="text-primary hover:text-primary/80"
          >
            Ver formulario
          </button>
        </div>
      </div>
    </div>
  </div>
</template>