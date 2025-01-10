<script setup>
import TeacherAvatar from './TeacherAvatar.vue'
import { useTeachersStore } from '@/stores/teachersStore';
import { useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'

const teachersStore = useTeachersStore()
const route = useRoute()
const teacher = ref(null)
onMounted(() => {
  const teacherId = route.params.id
  teacher.value = teachersStore.getTeacherById(teacherId)
})

</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
      <div class="flex items-start space-x-6">
        <TeacherAvatar
          :name="teacher.name"
          :image="teacher.image"
          class="flex-shrink-0"
        />
        <TeacherInfo
          :name="teacher.name"
          :course="teacher.course"
          :email="teacher.email"
        />
      </div>
    </div>
  </div>
</template>