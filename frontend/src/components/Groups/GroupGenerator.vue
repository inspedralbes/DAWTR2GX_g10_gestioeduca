<script setup>
import { ref, computed } from 'vue'
import { generateGroups } from '@/components/utils/groupGenerator'

const props = defineProps({
  students: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['generate'])

const groupSize = ref(4)
const balanceBy = ref('none')
const generatedGroups = ref([])

const balanceOptions = [
  { value: 'none', label: 'Aleatori' },
  { value: 'performance', label: 'Rendimient' },
  { value: 'attendance', label: 'Assistència' }
]

const handleGenerate = () => {
  try {
    const options = {
      groupSize: groupSize.value,
      balanceBy: balanceBy.value === 'none' ? null : balanceBy.value
    }
    
    const groups = generateGroups(props.students, options)
    generatedGroups.value = groups
    emit('generate', groups)
  } catch (error) {
    console.error('Error al generar grupos:', error)
  }
}
</script>

<template>
  <div class="card">
    <h2 class="text-lg font-semibold mb-4">Generador de Grups</h2>
    
    <div class="space-y-4">
      <!-- Configuration -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Tamany dels grups
          </label>
          <input
            v-model.number="groupSize"
            type="number"
            min="2"
            :max="students.length"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
          />
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Equilibrar per
          </label>
          <select
            v-model="balanceBy"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
          >
            <option
              v-for="option in balanceOptions"
              :key="option.value"
              :value="option.value"
            >
              {{ option.label }}
            </option>
          </select>
        </div>
      </div>

      <button
        @click="handleGenerate"
        class="w-full btn btn-primary"
      >
        Generar Grups
      </button>
    </div>
  </div>
</template>