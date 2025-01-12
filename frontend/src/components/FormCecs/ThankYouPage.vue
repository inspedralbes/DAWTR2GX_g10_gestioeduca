  
  <template>
    <div class="min-h-screen bg-blue-50 flex items-center justify-center p-4">
      <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8 text-center">
        <div class="mb-6">
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-24 w-24 mx-auto text-green-500"
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
          >
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" 
            />
          </svg>
        </div>
        
        <h2 class="text-3xl font-bold text-blue-700 mb-4">¡Gracias, {{ studentInfo.name }}!</h2>
        
        <p class="text-gray-600 mb-6">
          Tu cuestionario ha sido enviado correctamente. 
          Apreciamos tu tiempo y colaboración.
        </p>
        
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
          <h3 class="font-semibold text-blue-800 mb-2">Detalles del Envío</h3>
          <ul class="text-gray-700 text-left max-w-xs mx-auto">
            <li><strong>Centro:</strong> {{ studentInfo.school }}</li>
            <li><strong>Curso:</strong> {{ studentInfo.course }}</li>
            <li><strong>Fecha de envío:</strong> {{ formattedDate }}</li>
          </ul>
        </div>
        
        <button 
          @click="$emit('reset')"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full"
        >
          Volver al inicio
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    studentInfo: {
      type: Object,
      required: true
    }
  })
  
  const formattedDate = computed(() => {
    return new Date().toLocaleDateString('es-ES', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    })
  })
  
  defineEmits(['reset'])
  </script>