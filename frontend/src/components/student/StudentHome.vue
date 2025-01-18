<template>
  <div class="p-6 space-y-6">
    <ProfileCard />
    <div class="p-6 space-y-6">
      <FormsCard />
    </div>
  </div>
</template>

<script setup>
import ProfileCard from './dashboard/ProfileCard.vue';
import FormsCard from './dashboard/FormsCard.vue';
</script>