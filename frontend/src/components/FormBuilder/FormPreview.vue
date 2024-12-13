<script setup>
import { ref, watch } from 'vue'
import { useTypingEffect } from '../utils/chat'
import QuestionActions from './QuestionActions.vue'
import QuestionEditorModal from './QuestionEditorModal.vue'

const props = defineProps({
  questions: {
    type: Array,
    required: true
  },
  title: String,
  description: String,
  context: String
})

const emit = defineEmits(['edit-question', 'regenerate-question', 'save', 'send'])
const visibleQuestions = ref([])
const loadingQuestionId = ref(null)
const showEditorModal = ref(false)
const selectedQuestion = ref(null)
const { content: titleContent, typeMessage: typeTitle } = useTypingEffect(50)
const { content: descriptionContent, typeMessage: typeDescription } = useTypingEffect(30)

watch(() => props.title, async (newTitle) => {
  if (newTitle) {
    await typeTitle(newTitle)
  }
}, { immediate: true })

watch(() => props.description, async (newDescription) => {
  if (newDescription) {
    await typeDescription(newDescription)
  }
}, { immediate: true })

watch(() => props.questions, async (newQuestions) => {
  visibleQuestions.value = []
  for (let i = 0; i < newQuestions.length; i++) {
    await new Promise(resolve => setTimeout(resolve, 500))
    visibleQuestions.value.push(newQuestions[i])
  }
}, { immediate: true })

const handleEditQuestion = (question) => {
  selectedQuestion.value = question
  showEditorModal.value = true
}

const handleSaveQuestion = (editedQuestion) => {
  emit('edit-question', { question: editedQuestion })
}

const handleRegenerateQuestion = async (question) => {
  loadingQuestionId.value = question.id
  await emit('regenerate-question', question)
  loadingQuestionId.value = null
}

const handleSave = () => {
  emit('save')
}

const handleSend = () => {
  emit('send')
}

const handleDownload = () => {
  const formData = {
    title: props.title,
    description: props.description,
    questions: props.questions
  }

  const json = JSON.stringify(formData, null, 2) // Convertir a JSON con formato legible
  const blob = new Blob([json], { type: 'application/json' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = 'formulario.json' // Nombre del archivo a descargar
  link.click()
}
</script>

<template>
  <div class="space-y-6">
    <div v-if="title" class="card animate-fade-in">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold mb-2">{{ titleContent }}</h2>
        <button @click="handleDownload" class="text-gray-600 hover:text-primary transition duration-200">
          <!-- Ícono de descarga (Heroicons) -->
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg>
        </button>
      </div>
      <p class="text-gray-600">{{ descriptionContent }}</p>
    </div>

    <div v-for="(question, index) in visibleQuestions" :key="index"
      class="border rounded-lg p-6 bg-white animate-slide-up">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-medium">{{ question.title }}</h3>
        <QuestionActions :question="question" :is-loading="loadingQuestionId === question.id" @edit="handleEditQuestion"
          @regenerate="handleRegenerateQuestion" />
      </div>

      <div class="space-y-4">
        <template v-if="['multiple', 'checkbox'].includes(question.type)">
          <div v-for="option in question.options" :key="option.value" class="flex items-center space-x-2">
            <input :type="question.type === 'multiple' ? 'radio' : 'checkbox'" :name="`question-${index}`"
              :value="option.value" class="w-4 h-4 text-primary focus:ring-primary" />
            <label class="text-gray-700">{{ option.text }}</label>
          </div>
        </template>

        <template v-else-if="question.type === 'text'">
          <textarea rows="3"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
            placeholder="Tu respuesta..."></textarea>
        </template>

        <template v-else-if="question.type === 'number'">
          <input type="number"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
            placeholder="0" />
        </template>
      </div>
    </div>

    <!-- Action Buttons -->
    <div v-if="questions.length > 0" class="flex justify-end space-x-4 pt-4">
      <button @click="handleSave" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
        Guardar
      </button>
      <button @click="handleSend" class="btn btn-primary">
        Enviar
      </button>
    </div>

    <!-- Question Editor Modal -->
    <QuestionEditorModal v-model="showEditorModal" :question="selectedQuestion" @save="handleSaveQuestion" />
  </div>
</template>
