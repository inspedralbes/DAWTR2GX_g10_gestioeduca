<template>
    <div class="bg-blue-100 p-4">
      <div class="flex justify-between items-center">
        <span class="text-sm text-blue-700">
          Pregunta {{ currentStep + 1 }} de {{ totalSteps }}
        </span>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mx-4">
          <div 
            class="bg-blue-600 h-2.5 rounded-full" 
            :style="{ width: `${(currentStep + 1) / totalSteps * 100}%` }"
          ></div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    currentStep: {
      type: Number,
      required: true
    },
    totalSteps: {
      type: Number,
      required: true
    }
  })
  </script>  