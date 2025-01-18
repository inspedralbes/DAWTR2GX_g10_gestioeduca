export function useStudentSkills() {
  const getSkillLevel = (value) => {
    if (value >= 90) return 'Excelente'
    if (value >= 75) return 'Avanzado'
    if (value >= 60) return 'Competente'
    if (value >= 40) return 'En desarrollo'
    return 'Inicial'
  }

  const getSkillColor = (value) => {
    if (value >= 90) return 'success'
    if (value >= 75) return 'primary'
    if (value >= 60) return 'warning'
    return 'secondary'
  }

  return {
    getSkillLevel,
    getSkillColor
  }
}