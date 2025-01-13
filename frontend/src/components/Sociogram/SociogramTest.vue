<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useStudentsStore } from "@/stores/studentsStore";
import {
  UserGroupIcon,
  UserIcon,
  StarIcon,
  HeartIcon,
  LightBulbIcon,
  CheckCircleIcon,
} from "@heroicons/vue/24/outline";

// Inicializamos el enrutador y el store
const router = useRouter();
const studentsStore = useStudentsStore();

// Obtener estudiantes desde el store al montar el componente
const students = ref([]);

onMounted(async () => {
  if (studentsStore.studentCount === 0) {
    // Si no se han cargado los estudiantes, realizamos el fetch
    await studentsStore.fetchStudents();
  }
  students.value = studentsStore.students;
});

// Definimos las secciones del cuestionario
const sections = [
  {
    title: "¿Con quién prefieres trabajar?",
    description: "Selecciona 3 compañeros/as con los que prefieres trabajar en clase",
    id: 15,
    icon: UserGroupIcon,
    selectionKey: "preferredWorkPartners",
    maxSelections: 3,
  },
  {
    title: "¿Con quién prefieres no trabajar?",
    description: "Selecciona 3 compañeros/as con los que prefieres evitar trabajar",
    id: 16,
    icon: UserIcon,
    selectionKey: "avoidWorkPartners",
    maxSelections: 3,
  },
  {
    title: "¿Con quién has trabajado anteriormente?",
    description: "Selecciona 3 compañeros/as con los que hayas trabajado anteriormente",
    id: 17,
    icon: UserIcon,
    selectionKey: "habitualWorkPartners",
    maxSelections: 3,
  },

  {
    title: "Quién tiene habilidades de liderazgo",
    description: "Selecciona 2 compañeros/as que consideras buenos líderes",
    id: 18,
    icon: StarIcon,
    selectionKey: "potentialLeaders",
    maxSelections: 2,
  },
  {
    title: "Quién tiene habilidades de creatividad",
    description: "Selecciona 2 compañeros/as que consideras más creativos",
    id: 19,
    icon: LightBulbIcon,
    selectionKey: "creativePeople",
    maxSelections: 2,
  },
  {
    title: "Quién tiene habilidades de organización",
    description: "Selecciona 2 compañeros/as que son más organizados",
    id: 20,
    icon: HeartIcon,
    selectionKey: "organizedPeople",
    maxSelections: 2,
  },
  {
    title: "¿Con quién no has trabajado anteriormente?",
    description: "Selecciona 2 compañeros/as con los que no hayas trabajado anteriormente",
    id: 21,
    icon: UserIcon,
    selectionKey: "inhabitualWorkPartners",
    maxSelections: 2,
  },
];

// Respuestas y variables de estado
const selections = ref({
  preferredWorkPartners: [],
  avoidWorkPartners: [],
  habitualWorkPartners: [],
  potentialLeaders: [],
  creativePeople: [],
  organizedPeople: [],
  inhabitualWorkPartners: []
});

const currentSection = ref(0);
const showResults = ref(false);

const currentSectionData = computed(() => sections[currentSection.value]);

const handleClassmateSelection = (student) => {
  const currentSelections = selections.value[currentSectionData.value.selectionKey];

  if (currentSelections.includes(student)) {
    selections.value[currentSectionData.value.selectionKey] = currentSelections.filter(
      (s) => s !== student
    );
  } else if (currentSelections.length < currentSectionData.value.maxSelections) {
    selections.value[currentSectionData.value.selectionKey] = [...currentSelections, student];
  }
};

const isClassmateSelectable = (name) => {
  if (currentSection.value === 1) {
    return !selections.value.preferredWorkPartners.includes(name);
  }
  return true;
};

const nextSection = () => {
  const currentSelections = selections.value[currentSectionData.value.selectionKey];
  if (currentSelections.length === currentSectionData.value.maxSelections) {
    if (currentSection.value < sections.length - 1) {
      currentSection.value++;
    } else {
      showResults.value = true;
    }
  }
};

const prevSection = () => {
  if (currentSection.value > 0) {
    currentSection.value--;
  }
};

// Obtener el ID del estudiante logueado desde localStorage
const getLoggedStudentId = () => {
  const loggedUser = JSON.parse(localStorage.getItem("user")); // Obtener los datos completos del usuario
  return loggedUser ? loggedUser.id : null; // Retornar el ID del usuario logueado
};

const handleFinish = async () => {
 
  try {
    console.log("handleFinish ha sido llamado");
    const studentId = getLoggedStudentId();
    
    if (!studentId) {
      throw new Error("Estudiante no identificado.");
    }

    const relationshipTypes = {
      preferredWorkPartners: "positive",
      avoidWorkPartners: "negative",
      habitualWorkPartners: "positive",
      potentialLeaders: "positive",
      creativePeople: "positive",
      organizedPeople: "positive",
      inhabitualWorkPartners: "positive",
    };

    // Preparar las respuestas para enviar al backend
    const answers = [];

    sections.forEach((section) => {
      const currentSelections = selections.value[section.selectionKey];

      currentSelections.forEach((student) => {
        answers.push({
          peer_id: student.id, // ID del compañero seleccionado
          question_id: section.id, // Índice basado en la sección
          relationship_type: relationshipTypes[section.selectionKey], // Tipo de relación
        });
      });
    });

    // Enviar los datos al backend
    const response = await fetch("http://localhost:8000/api/sociogram-relationships", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        user_id: studentId, // ID del usuario logueado
        relationships: answers, // Relaciones enviadas
      }),
    });
    console.log("Datos enviados al backend:", JSON.stringify({
    user_id: studentId,
    relationships: answers,
    }, null, 2));
    console.log("Respuesta del backend:", response);

    if (!response.ok) {
      throw new Error("Error al enviar las respuestas.");
    }

    const completedForms = JSON.parse(localStorage.getItem("completedForms") || "[]");
    completedForms.push("sociogram");
    localStorage.setItem("completedForms", JSON.stringify(completedForms));
   
    router.push("/student/forms");
  } catch (error) {
    console.error("Error al enviar las respuestas:", error);
  }
};

</script>

<template>
  <div class="max-w-4xl mx-auto">
    <div v-if="!showResults" class="bg-white rounded-lg shadow-lg p-6">
      <h1 class="text-2xl font-bold mb-4 text-center">Cuestionario Sociométrico</h1>

      <div class="mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-3">
          <component :is="currentSectionData.icon" class="w-6 h-6 text-primary" />
          {{ currentSectionData.title }}
        </h2>
        <p class="text-gray-600 mt-2">{{ currentSectionData.description }}</p>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <button
          v-for="student in students"
          :key="student.id"
          @click="handleClassmateSelection(student)"
          :disabled="!isClassmateSelectable(student)"
          :class="[ 
            'p-3 rounded-lg transition-all text-sm', 
            selections[currentSectionData.selectionKey].includes(student)
              ? 'bg-blue-100 border-2 border-blue-500' 
              : isClassmateSelectable(student)
              ? 'bg-gray-100 hover:bg-gray-200' 
              : 'bg-red-50 text-red-600 cursor-not-allowed opacity-50'
          ]"
        >
          {{ student.name }} {{ student.last_name }}
          <CheckCircleIcon
            v-if="selections[currentSectionData.selectionKey].includes(student)"
            class="inline ml-2 w-4 h-4 text-blue-600"
          />
        </button>
      </div>

      <div class="flex justify-between mt-6">
        <button v-if="currentSection > 0" @click="prevSection" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
          Anterior
        </button>
        <button
          @click="nextSection"
          class="bg-primary text-white px-4 py-2 rounded-lg ml-auto hover:bg-primary/90"
          :disabled="selections[currentSectionData.selectionKey].length !== currentSectionData.maxSelections"
        >
          {{ currentSection === sections.length - 1 ? "Ver Resultados" : "Siguiente" }}
        </button>
      </div>

      <div class="mt-4 text-center">
        <p class="text-gray-600">Sección {{ currentSection + 1 }} de {{ sections.length }}</p>
      </div>
    </div>

    <div v-else class="space-y-6">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Resumen de tus respuestas</h2>
        <div class="space-y-6">
          <div v-for="section in sections" :key="section.title" class="border-b pb-4">
            <div class="flex items-center gap-2 mb-2">
              <component :is="section.icon" class="w-5 h-5 text-primary" />
              <h3 class="font-semibold">{{ section.title }}</h3>
            </div>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="student in selections[section.selectionKey]"
                :key="student.id"
                class="bg-gray-100 px-3 py-1 rounded-full text-sm"
              >
                {{ student.name }} {{ student.last_name }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex justify-center">
        <button
          @click="handleFinish"
          class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 font-semibold"
        >
          Finalizar
        </button>
      </div>
    </div>
  </div>
</template>
