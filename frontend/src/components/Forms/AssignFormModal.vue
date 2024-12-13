<script setup>
import { ref } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { useFormAssignmentsStore } from '../../stores/formAssignments'

const props = defineProps({
  modelValue: Boolean,
  form: {
    type: Object,
    required: true
  },
  students: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['update:modelValue', 'assigned'])
const formAssignmentsStore = useFormAssignmentsStore()

const dueDate = ref(null)
const selectedStudents = ref(props.students.map(s => s.id))

const assignForm = () => {
  const studentsToAssign = props.students.filter(s => selectedStudents.value.includes(s.id))
  const assignments = formAssignmentsStore.assignFormToStudents(
    props.form,
    studentsToAssign,
    dueDate.value ? new Date(dueDate.value) : null
  )
  
  emit('assigned', assignments)
  emit('update:modelValue', false)
}

const close = () => {
  emit('update:modelValue', false)
}
</script>

<template>
  <div v-if="modelValue" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
      <div class="relative transform rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        <button
          @click="close"
          class="absolute right-4 top-4 text-gray-400 hover:text-gray-500"
        >
          <XMarkIcon class="h-6 w-6" />
        </button>

        <div class="mt-3 sm:mt-5">
          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
            Asignar Formulario
          </h3>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Fecha límite (opcional)
              </label>
              <input
                v-model="dueDate"
                type="date"
                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Estudiantes ({{ selectedStudents.length }} seleccionados)
              </label>
              <div class="max-h-60 overflow-y-auto border rounded-md p-2">
                <div
                  v-for="student in students"
                  :key="student.id"
                  class="flex items-center space-x-2 p-2 hover:bg-gray-50"
                >
                  <input
                    type="checkbox"
                    :id="'student-' + student.id"
                    v-model="selectedStudents"
                    :value="student.id"
                    class="rounded text-primary focus:ring-primary"
                  />
                  <label :for="'student-' + student.id">{{ student.name }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
          <button
            @click="close"
            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
          >
            Cancelar
          </button>
          <button
            @click="assignForm"
            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90"
          >
            Asignar Formulario
          </button>
        </div>
      </div>
    </div>
  </div>
</template>