<script setup>
import { ref } from 'vue'
// import { PlusIcon } from '@heroicons/vue/24/outline'
import GroupGenerator from '../../components/Groups/GroupGenerator.vue'
import GroupPreview from '../../components/Groups/GroupPreview.vue'
const students = ref([
  {
    id: 1,
    name: 'Ana García',
    performance: 88,
    attendance: 95
  },
  {
    id: 2,
    name: 'Carlos Rodríguez',
    performance: 76,
    attendance: 92
  },
  {
    id: 3,
    name: 'Laura Martínez',
    performance: 92,
    attendance: 88
  },
  {
    id: 4,
    name: 'David Sánchez',
    performance: 85,
    attendance: 90
  },
  {
    id: 5,
    name: 'Elena López',
    performance: 79,
    attendance: 94
  },
  {
    id: 6,
    name: 'Fernando Torres',
    performance: 83,
    attendance: 87
  }
])

const groups = ref([])

const handleGenerateGroups = (newGroups) => {
  groups.value = newGroups
}
</script>

<template>
  <div class="p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
      <h1 class="text-xl sm:text-2xl font-bold">Grupos de Clase</h1>
      <button class="w-full sm:w-auto btn btn-primary flex items-center justify-center space-x-2">
        <PlusIcon class="w-5 h-5" />
        <span>Nuevo Grupo Manual</span>
      </button>
    </div>

    <!-- Desktop View -->
    <div class="hidden sm:grid sm:grid-cols-2 gap-6">
      <div>
        <GroupGenerator
          :students="students"
          @generate="handleGenerateGroups"
        />
      </div>
      
      <div>
        <GroupPreview
          v-if="groups.length"
          :groups="groups"
        />
        <div
          v-else
          class="card text-center text-gray-500"
        >
          Configura y genera grupos para ver la vista previa
        </div>
      </div>
    </div>

    <!-- Mobile View -->
    <div class="sm:hidden space-y-6">
      <GroupGeneratorMobile
        :students="students"
        @generate="handleGenerateGroups"
      />
      
      <GroupPreviewMobile
        v-if="groups.length"
        :groups="groups"
      />
      <div
        v-else
        class="bg-white rounded-lg shadow-md p-4 text-center text-gray-500"
      >
        Configura y genera grupos para ver la vista previa
      </div>
    </div>
  </div>
</template>