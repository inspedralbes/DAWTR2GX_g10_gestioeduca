<script setup>
import { ref,onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { 
  PlusIcon, 
  FunnelIcon,
  DocumentDuplicateIcon,
  PencilIcon,
  TrashIcon,
  EyeIcon,
  UserGroupIcon,
  ChartBarIcon
} from '@heroicons/vue/24/outline'
import AssignFormModal from '../../components/Forms/AssignFormModal.vue'

const router = useRouter()
const searchQuery = ref('')
const selectedStatus = ref('all')
const selectedDate = ref('all')
const showAssignModal = ref(false)
const selectedForm = ref(null)
const forms = ref([])


onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/forms', {
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

const students = ref([
  {
    id: 1,
    name: 'Ana García',
    grade: '1º ESO'
  },
  {
    id: 2,
    name: 'Carlos Rodríguez',
    grade: '2º ESO'
  },
  {
    id: 3,
    name: 'Laura Martínez',
    grade: '1º ESO'
  }
])

const navigateToCreate = () => {
  router.push({ name: 'CreateForm' })
}

const viewResponses = (formId) => {
  router.push({ name: 'FormResponses', params: { id: formId } })
}

const openAssignModal = (form) => {
  selectedForm.value = form  // Asigna el formulario específico
  showAssignModal.value = true
}

const handleFormAssigned = (assignments) => {
  console.log('Form assigned to students:', assignments)
  // Show success message
  alert('Formulario asignado correctamente a los estudiantes seleccionados')
}
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Formularios</h1>
      <button 
        @click="navigateToCreate"
        class="btn btn-primary flex items-center space-x-2"
      >
        <PlusIcon class="w-5 h-5" />
        <span>Nuevo Formulario</span>
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar formularios..."
            class="w-full px-4 py-2 border rounded-lg"
          />
        </div>
        <div class="flex space-x-4">
          <select
            v-model="selectedStatus"
            class="px-4 py-2 border rounded-lg"
          >
            <option value="all">Todos los estados</option>
            <option value="active">Activos</option>
            <option value="draft">Borradores</option>
            <option value="closed">Cerrados</option>
          </select>
          <select
            v-model="selectedDate"
            class="px-4 py-2 border rounded-lg"
          >
            <option value="all">Todas las fechas</option>
            <option value="today">Hoy</option>
            <option value="week">Esta semana</option>
            <option value="month">Este mes</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Forms List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Título
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Estado
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Respuestas
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Fecha
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
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
                  {{ form.status === 1 ? 'activo' : 'inactivo' }}
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
                    <span>Asignar</span>
                  </button>
                  <button 
                    v-if="form.responses > 0"
                    class="flex items-center space-x-1 px-3 py-1 bg-success text-white rounded-md hover:bg-success/90 transition-colors"
                    @click="viewResponses(form.id)"
                    title="Ver respuestas"
                  >
                    <ChartBarIcon class="w-4 h-4" />
                    <span>Ver Respuestas</span>
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

    <!-- Assignment Modal -->
    <AssignFormModal
      v-model="showAssignModal"
      :form="selectedForm || {}"
      :students="students"
      @assigned="handleFormAssigned"
    />
  </div>
</template>