<script setup>
import { computed } from 'vue'
import StatCard from '../../Dashboard/StatCard.vue'
import { 
  UserGroupIcon, 
  CheckCircleIcon,
  ClockIcon,
  ChartBarIcon 
} from '@heroicons/vue/24/outline'

const props = defineProps({
  responses: {
    type: Array,
    required: true
  }
})

const totalResponses = computed(() => props.responses.length)

const completedResponses = computed(() => 
  props.responses.filter(r => r.division === 'completed').length
)

const completionRate = computed(() => 
  totalResponses.value ? (completedResponses.value / totalResponses.value * 100).toFixed(0) : 0
)

const averageTime = computed(() => {
  if (!props.responses.length) return '0:00'
  // Mock average time - In a real app, calculate from actual response times
  return '8:30'
})
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <StatCard
      title="Total Respuestas"
      :value="totalResponses"
      :icon="UserGroupIcon"
    />
    <StatCard
      title="Completadas"
      :value="completedResponses"
      :icon="CheckCircleIcon"
      color="success"
    />
    <StatCard
      title="Tasa de Finalización"
      :value="`${completionRate}%`"
      :icon="ChartBarIcon"
      color="primary"
    />
    <StatCard
      title="Tiempo Promedio"
      :value="averageTime"
      :icon="ClockIcon"
      color="warning"
    />
  </div>
</template>