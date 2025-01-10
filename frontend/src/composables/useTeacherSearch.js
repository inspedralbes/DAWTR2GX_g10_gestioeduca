import { ref, computed } from 'vue'

export function useTeacherSearch(teachers) {
  const searchQuery = ref('')
  const selectedCourse = ref('all')
  const selectedDivision = ref('all')

  const filteredTeachers = computed(() => {
    return teachers.value.filter(teacher => {
      const matchesSearch = teacher.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      teacher.email.toLowerCase().includes(searchQuery.value.toLowerCase())

      const matchesCourse = selectedCourse.value === 'all' || teacher.course.startsWith(selectedCourse.value)

      const matchesDivision = selectedDivision.value === 'all' || teacher.division === selectedDivision.value
      return matchesSearch && matchesCourse && matchesDivision
    })
  })

  return {
    searchQuery,
    selectedCourse,
    selectedDivision,
    filteredTeachers
  }
}