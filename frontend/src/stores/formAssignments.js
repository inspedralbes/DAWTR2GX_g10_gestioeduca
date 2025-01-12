import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFormAssignmentsStore = defineStore('formAssignments', () => {
  const assignments = ref([])

  const assignFormToStudents = (form, students, dueDate) => {
    const newAssignments = students.map(student => ({
      id: Date.now() + Math.random(),
      formId: form.id,
      formTitle: form.title,
      studentId: student.id,
      studentName: student.name,
      assignedDate: new Date().toISOString(),
      dueDate: dueDate?.toISOString(),
      division: 'pending'
    }))

    assignments.value.push(...newAssignments)
    return newAssignments
  }

  const getStudentAssignments = (studentId) => {
    return assignments.value.filter(a => a.studentId === studentId)
  }

  return {
    assignments,
    assignFormToStudents,
    getStudentAssignments
  }
})