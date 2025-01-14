<script setup>
import { computed } from 'vue'

const props = defineProps({
  groups: {
    type: Array,
    required: true
  }
})

const getGroupStats = (students) => {
  if (!students.length) return { performance: 0, attendance: 0 }
  
  const performance = students.reduce((sum, s) => sum + s.performance, 0) / students.length
  const attendance = students.reduce((sum, s) => sum + s.attendance, 0) / students.length
  
  return { performance, attendance }
}
</script>

<template>
  <div class="space-y-6">
    <div
      v-for="group in groups"
      :key="group.id"
      class="card hover:shadow-lg transition-shadow duration-200"
    >
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-semibold">{{ group.name }}</h3>
        <div class="text-sm text-gray-500">
          {{ group.students.length }} estudiants
        </div>
      </div>

      <div class="space-y-3">
        <div
          v-for="student in group.students"
          :key="student.id"
          class="flex items-center justify-between p-2 bg-gray-50 rounded-lg"
        >
          <span>{{ student.name }}</span>
          <div class="flex space-x-4 text-sm">
            <span class="text-success">{{ student.performance }}%</span>
            <span class="text-primary">{{ student.attendance }}%</span>
          </div>
        </div>
      </div>

      <div class="mt-4 pt-4 border-t grid grid-cols-2 gap-4 text-sm">
        <div>
          <span class="text-gray-500">Rendimient promedi:</span>
          <span class="ml-2 font-medium">
            {{ getGroupStats(group.students).performance.toFixed(1) }}%
          </span>
        </div>
        <div>
          <span class="text-gray-500">Assistència promedi:</span>
          <span class="ml-2 font-medium">
            {{ getGroupStats(group.students).attendance.toFixed(1) }}%
          </span>
        </div>
      </div>
    </div>
  </div>
</template>