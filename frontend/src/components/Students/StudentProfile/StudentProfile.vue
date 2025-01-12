<script setup>
import StudentAvatar from './StudentAvatar.vue'
//import StudentInfo from './StudentInfo.vue'
//import { useStudentSkills } from '../../../composables/useStudentSkills'
import { useStudentsStore } from '@/stores/studentsStore'
import { useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'

const studentsStore = useStudentsStore()
const route = useRoute()
const student = ref(null)
onMounted(() => {
  const studentId = route.params.id
  student.value = studentsStore.getStudentById(studentId)
})

</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
      <div class="flex items-start space-x-6">
        <StudentAvatar
          :name="student.name"
          :image="student.image"
          class="flex-shrink-0"
        />
        
        <StudentInfo
          :name="student.name"
          :course="student.course"
          :email="student.email"
        />
      </div>
    </div>
  </div>
</template>