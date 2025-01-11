<script setup>
import { ref, onMounted } from 'vue';
import { defineStore } from 'pinia';

// Crear un store Pinia para los grupos
const useGroupStore = defineStore('groups', {
  state: () => ({
    groups: []
  }),
  actions: {
    async fetchGroups() {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await fetch('http://localhost:8000/api/groups', {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });
        
        if (!response.ok) {
          throw new Error('Error fetching groups');
        }

        const data = await response.json();
        this.groups = data;
      } catch (error) {
        console.error('Error fetching groups:', error);
      }
    }
  }
});

const groupStore = useGroupStore();

onMounted(() => {
  groupStore.fetchGroups();
});

// Función para obtener la clase de estado
const getStatusClass = (status) => {
  const classes = {
    'Activo': 'bg-green-100 text-green-800',
    'Pendiente': 'bg-yellow-100 text-yellow-800',
    'Próximo': 'bg-blue-100 text-blue-800'
  }
  return `px-3 py-1 rounded-full text-sm font-medium ${classes[status] || ''}`
}
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Mis Grupos</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div v-for="group in groupStore.groups" :key="group.id" 
        class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="text-lg font-semibold">{{ group.name }}</h3>
            <p class="text-gray-600">{{ group.subject }}</p>
          </div>
          <span :class="getStatusClass(group.status)">
            {{ group.status }}
          </span>
        </div>

        <div class="mb-4">
          <button 
            @click="toggleMembers(group.id)"
            class="flex items-center text-primary hover:text-primary/80"
          >
            <span>{{ group.isExpanded ? 'Ocultar' : 'Ver' }} integrantes</span>
            <ChevronDownIcon 
              class="w-5 h-5 ml-1 transform transition-transform"
              :class="{ 'rotate-180': group.isExpanded }"
            />
          </button>
        </div>

        <div v-if="group.isExpanded" class="space-y-3 animate-fade-in">
          <div v-for="member in group.members" :key="member.id"
            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center text-sm font-medium text-primary">
                {{ member.initials }}
              </div>
              <span>{{ member.name }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
