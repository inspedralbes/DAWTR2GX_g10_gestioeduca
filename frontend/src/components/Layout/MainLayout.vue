<script setup>
import Sidebar from './Sidebar.vue'
</script>

<template>
  <div class="min-h-screen bg-background">
    <Sidebar />
    <div class="lg:pl-64">
      <div class="min-h-[4rem] lg:min-h-0"></div>
      <slot></slot>
    </div>
  </div>
</template>