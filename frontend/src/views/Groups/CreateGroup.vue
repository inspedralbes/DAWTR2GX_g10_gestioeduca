<script setup>
import { ref, onMounted } from 'vue';
import ProfileHeader from '../../components/StudentProfile/ProfileHeader.vue';
import Footer from '../../components/common/Footer.vue';

const isLoading = ref(true);
const students = ref([]);
const teachers = ref([]);
const groupName = ref('');
const groupDescription = ref('');
const selectedCourse = ref(null); 
const selectedDivisio = ref(null);
const selectedStudents = ref([]);
const selectedSubject = ref([]);

const totalStudents = ref(0);
const groups = ref([]); 
//recargar grupos
const loadGroups = () => {
  fetch('/groups.json')
    .then(response => response.json())
    .then(data => {
    // console.log(data);
    groups.value = data;
    });
};
// Función para obtener los estudiantes 
const fetchStudents = async () => {
  try {
    const response = await fetch('/students.json'); // URL de la API de estudiantes
    if (!response.ok) throw new Error('Error al recargar estudiants');
    students.value = await response.json();
  } catch (error) {
    console.error(error);
  }
};

// Función para obtener los profesores
const fetchTeachers = async () => {
  try {
    const response = await fetch('/teachers.json'); // URL de la API de profesores
    if (!response.ok) throw new Error('Error al recargar profesors');
    teachers.value = await response.json();
  } catch (error) {
    console.error(error);
  }
};
const createGroup = () => {
  // Validaciones básicas
  if (!groupName.value || selectedStudents.value.length === 0 || selectedTeachers.value.length === 0) {
    alert('El nom del grupo, almenys un estudiant i un professor son obligatoris.');
    return;
  }

  // Simular nuevo grupo
  const newGroup = {
    group_id: Date.now(), // ID único para el grupo (puedes ajustarlo según las necesidades)
    description: groupDescription.value || null,
    course: selectedCourse.value,
    divisio: selectedDivisio.value,
    subject: selectedSubject.value,
    students: selectedStudents.value.map(student => ({
    student_id: student.id,
    name: student.name,
    surname: student.surname,
    })),
  };

  // Actualizar el archivo `groups.json`
  fetch('/groups.json', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify([...groups.value, newGroup]) // Agrega el nuevo grupo a la lista
  })
    .then(response => {
      if (response.ok) {
        groups.value.push(newGroup); // Actualizar grupos locales
        resetForm(); // Limpiar formulario
        alert('Grup creat amb éxit.');
      } else {
        throw new Error('Grup no creat. Hi ha hagut un error.');
      }
    })
    .catch(error => console.error(error));
};

// Limpiar el formulario
const resetForm = () => {
  groupName.value = '';
  groupDescription.value = '';
  selectedCourse.value = null;
  selectedDivisio.value = null;
  selectedStudents.value = [];
  selectedSubject.value = null;
};


// Lógica para cargar los datos al montar el componente
loadGroups(); 
onMounted(async () => {
  await fetchStudents();
  await fetchTeachers();
  isLoading.value = false;
});
</script>

<template>
    <!-- Indicador de carga -->
  <div v-if="isLoading" class="loading">
    <p>Carregant...</p>
  </div>

  <div v-else class="flex flex-col min-h-screen">
    <!-- Cabecera del perfil -->
    <ProfileHeader />
    <div class="group-container mx-auto p-4">
      <h1 class="text-lg font-bold mb-6">Crear un nou grup</h1>
  
      <!-- Formulario en Grid -->
      <form class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Nombre del grupo -->
        <div>
          <label for="group-name" class="block font-semibold">Nom del grup</label>
          <input v-model="groupName" id="group-name" type="text" class="w-full p-2 border rounded mb-4" />
        </div>
  
        <!-- Descripción del grupo -->
        <div>
          <label for="group-description" class="block font-semibold">Descripció</label>
          <textarea v-model="groupDescription" id="group-description" class="w-full p-2 border rounded mb-4"></textarea>
        </div>
  
        <!-- Seleccionar curso -->
        <div>
          <label for="course" class="block font-semibold">Curs</label>
          <select v-model="selectedCourse" id="course" class="w-full p-2 border rounded mb-4">
            <option disabled value="">Selecciona un curs</option>
            <option value="1º ESO">1º ESO</option>
            <option value="2º ESO">2º ESO</option>
            <option value="3º ESO">3º ESO</option>
            <option value="4º ESO">4º ESO</option>
          </select>
          </div>

          <!-- Seleccionar divisio -->
          <div>
          <label for="divisio" class="block font-semibold">Divisió</label>
          <select v-model="selectedDivisio" id="divisio" class="w-full p-2 border rounded mb-4">
            <option disabled value="">Selecciona divisió</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
          </select>
        </div>

          <!-- Seleccionar assignatura -->
          <div>
          <label for="subject" class="block font-semibold">Assignatura</label>
          <select v-model="selectedSubject" id="subjects" class="w-full p-2 border rounded mb-4">
            <option disabled value="">Selecciona assignatura</option>
            <option value="matemàtiques">Matemàtiques</option>
            <option value="B">Història</option>
            
          </select>
        </div>
  
        <!-- Seleccionar estudiantes -->
        <div class="col-span-1 sm:col-span-2">
          <label for="students" class="block font-semibold">Seleccionar Estudiants</label>
          <div id="students" class="border rounded p-3 mb-4 max-h-40 overflow-y-auto">
            <div v-for="student in students" :key="student.id" class="flex items-center gap-2 mb-2">
              <input type="checkbox" :value="student" v-model="selectedStudents" />
              <span>{{ student.name }} {{ student.surname }}</span>
            </div>
          </div>
        </div>
  
        <!-- Botón para crear el grupo -->
        <div class="col-span-1 sm:col-span-2 flex justify-end">
          <button @click="createGroup" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Crear Grup
          </button>
        </div>
      </form>
  
      <!-- Botón "Llistar Groups" -->
      <!-- <div class="mt-6 flex justify-center">
        <router-link to="/groupsList">
          <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Llistar Groups
          </button>
        </router-link>
      </div> -->
    </div>
     <!-- Pie de página -->
     <Footer />
  </div>
  </template>
  
<style scoped>
.group-container {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  flex-grow: 1; /* Hace que la lista crezca para llenar el espacio disponible */
}
</style>
