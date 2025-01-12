<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { format } from 'date-fns'

const props = defineProps({
  modelValue: Boolean,
  response: {
    type: Object,
    required: true
  },
  form: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const close = () => {
  emit('update:modelValue', false)
}

const getQuestionById = (questionId) => {
  return props.form.questions.find(q => q.id === questionId)
}

const formatAnswer = (answer, question) => {
  if (!answer) return 'Sin respuesta'
  
  if (question.type === 'checkbox' && Array.isArray(answer.value)) {
    return answer.value.join(', ')
  }
  
  return answer.value
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

        <div class="mb-6">
          <h3 class="text-lg font-medium text-gray-900">
            Respuesta de {{ response.studentName }}
          </h3>
          <p class="text-sm text-gray-500">
            Enviado el {{ format(new Date(response.submittedAt), 'dd/MM/yyyy HH:mm') }}
          </p>
          <div class="mt-1">
            <span 
              class="px-2 py-1 text-xs rounded-full"
              :class="{
                'bg-success/10 text-success': response.division === 'completed',
                'bg-warning/10 text-warning': response.division === 'partial'
              }"
            >
              {{ response.division === 'completed' ? 'Completado' : 'Parcial' }}
            </span>
          </div>
        </div>

        <div class="space-y-6">
          <div
            v-for="question in form.questions"
            :key="question.id"
            class="border-b pb-4"
          >
            <h4 class="font-medium text-gray-700 mb-2">
              {{ question.title }}
            </h4>
            <p class="text-gray-900">
              {{ formatAnswer(response.answers.find(a => a.questionId === question.id), question) }}
            </p>
          </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
          <button
            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
            @click="close"
          >
            Cerrar
          </button>
          <button
            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90"
          >
            Añadir Comentario
          </button>
        </div>
      </div>
    </div>
  </div>
</template>