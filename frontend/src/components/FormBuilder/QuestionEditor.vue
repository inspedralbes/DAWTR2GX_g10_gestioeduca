<script setup>
import { ref, computed } from 'vue'
import { TrashIcon } from '@heroicons/vue/24/outline'
import { questionTypes } from './QuestionTypes'

const props = defineProps({
  question: {
    type: Object,
    required: true
  },
  index: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['update:question', 'delete'])

const questionType = computed(() => 
  questionTypes.find(type => type.id === props.question.type)
)

const options = ref(props.question.options || [])

const addOption = () => {
  options.value.push({ text: '', value: options.value.length })
  updateQuestion()
}

const removeOption = (index) => {
  options.value.splice(index, 1)
  updateQuestion()
}

const updateQuestion = () => {
  emit('update:question', {
    ...props.question,
    options: options.value
  })
}
</script>

<template>
  <div class="border rounded-lg p-6 bg-white mb-4">
    <div class="flex justify-between items-start mb-4">
      <div class="flex-1">
        <input
          v-model="question.title"
          class="w-full text-lg font-medium mb-2 px-2 py-1 border-b border-transparent focus:border-primary outline-none"
          placeholder="Escriu la teva pregunta aquí"
          @input="updateQuestion"
        />
        <p class="text-sm text-gray-500">{{ questionType?.label }}</p>
      </div>
      <button
        @click="$emit('delete')"
        class="text-gray-400 hover:text-danger"
      >
        <TrashIcon class="w-5 h-5" />
      </button>
    </div>

    <div class="space-y-4">
      <!-- Opciones para preguntas de selección -->
      <template v-if="['multiple', 'checkbox'].includes(question.type)">
        <div
          v-for="(option, index) in options"
          :key="index"
          class="flex items-center space-x-2"
        >
          <div class="w-6 h-6 flex-shrink-0">
            <component
              :is="question.type === 'multiple' ? 'input' : 'input'"
              :type="question.type === 'multiple' ? 'radio' : 'checkbox'"
              disabled
              class="w-4 h-4"
            />
          </div>
          <input
            v-model="option.text"
            class="flex-1 px-3 py-2 border rounded-md"
            placeholder="Opción de respuesta"
            @input="updateQuestion"
          />
          <button
            @click="removeOption(index)"
            class="text-gray-400 hover:text-danger"
          >
            <TrashIcon class="w-4 h-4" />
          </button>
        </div>
        <button
          @click="addOption"
          class="text-primary hover:text-primary/80 text-sm font-medium"
        >
          + Afegir opció
        </button>
      </template>

      <!-- Configuración para otros tipos de preguntas -->
      <template v-else>
        <div class="text-sm text-gray-500">
          <template v-if="question.type === 'text'">
            Camp de text lliure
          </template>
          <template v-else-if="question.type === 'number'">
            Camp numèric
          </template>
        </div>
      </template>
    </div>
  </div>
</template>