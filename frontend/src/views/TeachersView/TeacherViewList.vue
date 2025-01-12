<script setup>
import { ref, onMounted, computed } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline'
import TeacherList from '@/components/Teachers/TeacherList.vue'
import TeacherFilters from '@/components/Teachers/TeacherFilters.vue'
import { useTeacherSearch } from '@/composables/useTeacherSearch'
import { useTeachersStore } from '@/stores/teachersStore'

const teachersStore = useTeachersStore()
const isLoading = ref(true)

onMounted(async () => {
  await teachersStore.fetchTeachers()
  isLoading.value = false
})

const teachers = computed(() => teachersStore.teachers || [])

const {
  searchQuery,
  selectedCourse,
  selectedDivision,
  filteredTeachers
} = useTeacherSearch(teachers)

</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Profesores</h1>
    </div>
    <div v-if="isLoading" class="text-center p-8">
      Cargando profesores...
    </div>
    <div v-else>
      <TeacherFilters 
        v-model:searchQuery="searchQuery"
        v-model:selectedCourse="selectedCourse"
        v-model:selectedDivision="selectedDivision"
      />
      <TeacherList :teachers="filteredTeachers" />
      
    </div>
  </div>
</template>