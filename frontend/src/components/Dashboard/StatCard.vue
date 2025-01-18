<script setup>
defineProps({
  title: String,
  value: [String, Number],
  icon: Object,
  trend: Number,
  color: {
    type: String,
    default: 'primary',
  },
});
</script>

<template>
  <div class="card">
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-lg font-medium text-gray-600">{{ title }}</h3>
        <p class="text-2xl font-bold mt-2">{{ value }}</p>
      </div>
      <div :class="`bg-${color}/10 p-3 rounded-full`">
        <component :is="icon" class="w-6 h-6" :class="`text-${color}`" />
      </div>
    </div>
    <div class="mt-4 flex items-center" v-if="trend">
      <span :class="trend > 0 ? 'text-success' : 'text-danger'">
        {{ trend > 0 ? '+' : '' }}{{ trend }}%
      </span>
      <span class="text-gray-500 ml-2">vs mes anterior</span>
    </div>
  </div>
</template>
