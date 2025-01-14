<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { 
  PlusIcon, 
  DocumentDuplicateIcon,
  PencilIcon,
  TrashIcon,
  UserGroupIcon,
  ChartBarIcon
} from '@heroicons/vue/24/outline'
import AssignFormModal from '../../components/Forms/AssignFormModal.vue'

const router = useRouter()
const searchQuery = ref('')
const selectedDivision = ref('all')
const selectedDate = ref('all')
const showAssignModal = ref(false)
const selectedForm = ref(null)
const forms = ref([])

onMounted(async () => {
  try {
    const response = await fetch('http://pruebag10.daw.inspedralbes.cat/backend/public/api/forms', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Error obteniendo los datos.');
    }

    forms.value = await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
});

const navigateToCreate = () => {
  router.push({ name: 'CreateForm' })
}

const goToDashboard = () => {
  router.push('/dashboard')
}

const viewResponses = (formId) => {
  router.push({ name: 'FormResponses', params: { id: formId } })
}

const openAssignModal = (form) => {
  selectedForm.value = form
  showAssignModal.value = true
}

const handleFormAssigned = (assignments) => {
  console.log('Form assigned to students:', assignments)
  alert('Formulari assignat correctament als estudiants seleccionats')
}
</script>

<template>
  <div class="p-6">
    <!-- Contenedor del título y botón de volver -->
    <div class="relative flex items-center mb-6">
      <!-- Botón de volver -->
      <button 
        @click="goToDashboard" 
        class="absolute left-0 flex items-center space-x-1 text-gray-700 hover:text-gray-900"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Tornar</span>
      </button>

      <!-- Título centrado -->
      <h1 class="flex-grow text-center text-2xl font-bold">Formularis</h1>

      <!-- Botón de nuevo formulario -->
      <button 
        @click="navigateToCreate"
        class="absolute right-0 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center space-x-2"
      >
        <PlusIcon class="w-5 h-5" />
        <span>Nou Formulari</span>
      </button>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar formularis..."
            class="w-full px-4 py-2 border rounded-lg"
          />
        </div>
        <div class="flex space-x-4">
          <select
            v-model="selectedDivision"
            class="px-4 py-2 border rounded-lg"
          >
            <option value="all">Tots los estats</option>
            <option value="active">Actius</option>
            <option value="draft">Borradors</option>
            <option value="closed">Tancats</option>
          </select>
          <select
            v-model="selectedDate"
            class="px-4 py-2 border rounded-lg"
          >
            <option value="all">Totes les dates</option>
            <option value="today">Avui</option>
            <option value="week">Aquesta setmana</option>
            <option value="month">Aquest mes</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Lista de formularios -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Títol
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Estat
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Respostes
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Data
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Accions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="form in forms" :key="form.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">{{ form.title }}</div>
                <div class="text-sm text-gray-500">{{ form.description }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  :class="{
                  'bg-green-100 text-green-800': form.status === 1,
                  'bg-red-100 text-red-800': form.status === 0
                  }">
                  {{ form.status === 1 ? 'actiu' : 'inactiu' }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ form.responses }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ new Date(form.created_at).toLocaleDateString() }}
              </td>
              <td class="px-6 py-4 text-right text-sm font-medium">
                <div class="flex justify-end space-x-3">
                  <button 
                    class="flex items-center space-x-1 px-3 py-1 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors"
                    @click="openAssignModal(form)"
                    title="Asignar a estudiantes"
                  >
                    <UserGroupIcon class="w-4 h-4" />
                    <span>Assignar</span>
                  </button>
                  <button 
                    v-if="form.responses > 0"
                    class="flex items-center space-x-1 px-3 py-1 bg-success text-white rounded-md hover:bg-success/90 transition-colors"
                    @click="viewResponses(form.id)"
                    title="Ver respuestas"
                  >
                    <ChartBarIcon class="w-4 h-4" />
                    <span>Veure Respostes</span>
                  </button>
                  <button class="text-gray-400 hover:text-primary">
                    <PencilIcon class="w-5 h-5" />
                  </button>
                  <button class="text-gray-400 hover:text-primary">
                    <DocumentDuplicateIcon class="w-5 h-5" />
                  </button>
                  <button class="text-gray-400 hover:text-danger">
                    <TrashIcon class="w-5 h-5" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal de asignación -->
    <AssignFormModal
      v-model="showAssignModal"
      :form="selectedForm || {}"
      @assigned="handleFormAssigned"
    />
  </div>
</template>
