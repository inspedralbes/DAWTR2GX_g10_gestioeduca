import { shuffle } from './arrayUtils'

export function generateGroups(students, options = {}) {
  const {
    groupSize = 4,
    balanceBy = null, // 'performance', 'attendance', etc.
    avoidSameGroup = [], // Array of student IDs that shouldn't be in the same group
  } = options

  if (!students?.length) {
    throw new Error("No hi ha alumnes per generar els grups.")
  }

  let sortedStudents = [...students]

  if (balanceBy) {
    sortedStudents.sort((a, b) => b[balanceBy] - a[balanceBy])
  } else {
    sortedStudents = shuffle(sortedStudents)
  }

  const groups = []
  const numGroups = Math.ceil(sortedStudents.length / groupSize)

  // Initialize groups
  for (let i = 0; i < numGroups; i++) {
    groups.push([])
  }

  // Distribute students using snake pattern for balanced distribution
  sortedStudents.forEach((student, index) => {
    const groupIndex = index % numGroups
    const isReverse = Math.floor(index / numGroups) % 2 === 1
    const targetGroup = isReverse ? numGroups - 1 - groupIndex : groupIndex
    groups[targetGroup].push(student)
  })

  return groups.map((students, index) => ({
    id: Date.now() + index,
    name: `Grupo ${index + 1}`,
    students
  }))
}