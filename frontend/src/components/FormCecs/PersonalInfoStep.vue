<template>
    <div class="space-y-4">
      <h2 class="text-2xl font-bold text-blue-700 mb-4">Información Personal</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-2">Nombre</label>
          <input 
            :value="studentInfo.name" 
            @input="updateField('name', $event.target.value)"
            type="text" 
            required 
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Introduce tu nombre"
          />
        </div>
        
        <div>
          <label class="block mb-2">Género</label>
          <div class="flex space-x-4">
            <label class="flex items-center">
              <input 
                type="radio" 
                value="nen" 
                :checked="studentInfo.gender === 'nen'"
                @change="updateField('gender', 'nen')"
                required 
                class="mr-2"
              /> Niño
            </label>
            <label class="flex items-center">
              <input 
                type="radio" 
                value="nena" 
                :checked="studentInfo.gender === 'nena'"
                @change="updateField('gender', 'nena')"
                required 
                class="mr-2"
              /> Niña
            </label>
          </div>
        </div>
      </div>
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-2">Clase</label>
          <select 
            :value="studentInfo.course"
            @change="updateField('course', $event.target.value)"
            required
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Selecciona un curso</option>
            <option value="1r eso">1r ESO</option>
            <option value="2n eso">2n ESO</option>
            <option value="3r eso">3r ESO</option>
            <option value="4t eso">4t ESO</option>
          </select>
        </div>
  
        <div>
          <label class="block mb-2">Nom del tutor/a</label>
          <input 
            :value="studentInfo.tutorName" 
            @input="updateField('tutorName', $event.target.value)"
            type="text" 
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Nombre del tutor/a"
          />
        </div>
      </div>
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-2">Centre</label>
          <input 
            :value="studentInfo.school" 
            @input="updateField('school', $event.target.value)"
            type="text" 
            required
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Nombre del centro"
          />
        </div>
  
        <div>
          <label class="block mb-2">Población</label>
          <input 
            :value="studentInfo.city" 
            @input="updateField('city', $event.target.value)"
            type="text" 
            required
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Población"
          />
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits } from 'vue'
  
  const props = defineProps({
    studentInfo: {
      type: Object,
      required: true
    }
  })
  
  const emit = defineEmits(['update:studentInfo'])
  
  const updateField = (field, value) => {
    const updatedInfo = {
      ...props.studentInfo,
      [field]: value
    }
    emit('update:studentInfo', updatedInfo)
  }
  </script>