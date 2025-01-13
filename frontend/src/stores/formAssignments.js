import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFormAssignmentsStore = defineStore('formAssignments', () => {
  const assignments = ref([])

  const assignFormToStudents = async (form, students) => {
    const newAssignments = students.map(student => ({
      formId: form.id,
      studentId: student.id,
      assignedDate: new Date().toISOString(),
      division: 'pending'
    }))

    assignments.value.push(...newAssignments)

    // Realizar la solicitud POST para cada asignación
    for (const assignment of newAssignments) {
      try {
        const response = await fetch('http://localhost:8000/api/assign-form-to-user', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',

          },
          body: JSON.stringify({
            user_id: assignment.studentId,
            form_id: assignment.formId
          })
        })

        if (!response.ok) {
          throw new Error('Error en la asignación del formulario')
        }

        const result = await response.json()
        console.log('Asignación exitosa:', result)
      } catch (error) {
        console.error('Error al asignar el formulario:', error)
      }
    }

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