<template>
    <div>
      <h3 class="text-xl font-semibold text-blue-800 mb-4">
        {{ question.text }}
      </h3>
      
      <div class="grid grid-cols-3 gap-3">
        <div 
          v-for="student in students" 
          :key="student.id_student"
          class="relative"
        >
          <input 
            type="checkbox" 
            :id="`q${questionIndex}-student-${student.id_student}`"
            :value="student.id_student"
            :checked="selectedStudents.includes(student.id_student)"
            @change="toggleStudent(student.id_student)"
            :disabled="selectedStudents.length >= 3 && !selectedStudents.includes(student.id_student)"
            class="hidden peer"
          />
          <label 
            :for="`q${questionIndex}-student-${student.id_student}`"
            class="block p-2 text-center border rounded-lg cursor-pointer 
                   transition duration-300 
                   hover:bg-blue-100
                   peer-checked:bg-blue-500 peer-checked:text-white"
          >
            {{ student.name }} {{ student.surname }}
          </label>
        </div>
      </div>
      
      <p class="text-sm text-gray-600 mt-2">
        Seleccionats: {{ selectedStudents.length }}/3
      </p>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    question: {
      type: Object,
      required: true
    },
    questionIndex: {
      type: Number,
      required: true
    },
    students: {
      type: Array,
      required: true
    },
    selectedStudents: {
      type: Array,
      required: true
    }
  })
  
  const emit = defineEmits(['update:selectedStudents'])
  
  const toggleStudent = (studentId) => {
    let newSelectedStudents = [...props.selectedStudents]
    
    if (newSelectedStudents.includes(studentId)) {
      newSelectedStudents = newSelectedStudents.filter(id => id !== studentId)
    } else {
      if (newSelectedStudents.length < 3) {
        newSelectedStudents.push(studentId)
      }
    }
    
    emit('update:selectedStudents', newSelectedStudents)
  }
  </script>