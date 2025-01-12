<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import { 
  ChevronDownIcon, 
  ChatBubbleLeftRightIcon,
  ChartBarIcon,
  EyeIcon
} from '@heroicons/vue/24/outline';
import ResponsesTable from '../../components/Forms/Responses/ResponsesTable.vue';
import ResponseStats from '../../components/Forms/Responses/ResponseStats.vue';
import ResponseFilters from '../../components/Forms/Responses/ResponseFilters.vue';
import ResponseDetails from '../../components/Forms/Responses/ResponseDetails.vue';
import BulkActionsMenu from '../../components/Forms/Responses/BulkActionsMenu.vue';
import { useFormAnalyticsStore } from '../../stores/formAnalytics';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

const route = useRoute();
const formAnalyticsStore = useFormAnalyticsStore();
const showResponseDetails = ref(false);
const selectedResponse = ref(null);
const selectedResponses = ref([]);
const searchQuery = ref('');
const selectedCourse = ref('all');
const selectedDivision = ref('all');
const showDownloadMenu = ref(false);

// Mock data
const form = ref({
  id: route.params.id,
  title: 'Evaluación Trimestral',
  description: 'Evaluación del primer trimestre',
  questions: [
    {
      id: 1,
      title: '¿Cómo valorarías tu comprensión de la materia?',
      type: 'multiple',
      options: [
        { text: 'Excelente', value: 4 },
        { text: 'Buena', value: 3 },
        { text: 'Regular', value: 2 },
        { text: 'Necesito ayuda', value: 1 }
      ]
    },
    {
      id: 2,
      title: '¿Qué temas necesitas reforzar?',
      type: 'text'
    },
    {
      id: 3,
      title: '¿Qué aspectos de la clase te resultan más útiles?',
      type: 'checkbox',
      options: [
        { text: 'Explicaciones teóricas', value: 0 },
        { text: 'Ejercicios prácticos', value: 1 },
        { text: 'Trabajo en grupo', value: 2 },
        { text: 'Material complementario', value: 3 }
      ]
    }
  ]
});

const responses = ref([
  {
    id: 1,
    studentId: 1,
    studentName: 'Ana García',
    course: '1º ESO',
    submittedAt: '2024-03-10T10:30:00',
    division: 'completed',
    answers: [
      { questionId: 1, value: 'Buena' },
      { questionId: 2, value: 'Necesito reforzar álgebra y ecuaciones' },
      { questionId: 3, value: ['Ejercicios prácticos', 'Trabajo en grupo'] }
    ]
  },
  {
    id: 2,
    studentId: 2,
    studentName: 'Carlos Rodríguez',
    course: '2º ESO',
    submittedAt: '2024-03-11T09:15:00',
    division: 'completed',
    answers: [
      { questionId: 1, value: 'Regular' },
      { questionId: 2, value: 'Geometría y trigonometría' },
      { questionId: 3, value: ['Explicaciones teóricas', 'Material complementario'] }
    ]
  },
  {
    id: 3,
    studentId: 3,
    studentName: 'Laura Martínez',
    course: '1º ESO',
    submittedAt: '2024-03-11T11:45:00',
    division: 'partial',
    answers: [
      { questionId: 1, value: 'Excelente' },
      { questionId: 2, value: 'Ninguno en particular' }
    ]
  }
]);

const filteredResponses = computed(() => {
  return responses.value.filter(response => {
    const matchesSearch = response.studentName.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesCourse = selectedCourse.value === 'all' || response.course === selectedCourse.value;
    const matchesDivision = selectedDivision.value === 'all' || response.division === selectedDivision.value;
    return matchesSearch && matchesCourse && matchesDivision;
  });
});

const handleViewResponse = (response) => {
  selectedResponse.value = response;
  showResponseDetails.value = true;
};

const handleDownload = (format) => {
  if (format === 'csv') {
    const csvContent = generateCSV(responses.value);
    downloadFile(csvContent, `${form.value.title}_responses.csv`, 'text/csv;charset=utf-8;');
  } else if (format === 'json') {
    const jsonContent = JSON.stringify(responses.value, null, 2);
    downloadFile(jsonContent, `${form.value.title}_responses.json`, 'application/json;charset=utf-8;');
  } else if (format === 'pdf') {
    generatePDF(responses.value);
  }
};

const generatePDF = (responses) => {
  const doc = new jsPDF();

  // Título
  doc.setFontSize(18);
  doc.text(form.value.title, 10, 10);

  // Subtítulo
  doc.setFontSize(12);
  doc.text(form.value.description, 10, 20);

  // Configurar la tabla
  const tableData = responses.map(response => {
    const row = [
      response.studentName,
      response.course,
      new Date(response.submittedAt).toLocaleString(),
      response.division
    ];

    form.value.questions.forEach(question => {
      const answer = response.answers.find(a => a.questionId === question.id);
      row.push(answer ? Array.isArray(answer.value) ? answer.value.join(', ') : answer.value : '');
    });

    return row;
  });

  const headers = [
    'Estudiante', 
    'Curso', 
    'Fecha', 
    'Estado', 
    ...form.value.questions.map(q => q.title)
  ];

  doc.autoTable({
    head: [headers],
    body: tableData,
    startY: 30
  });

  // Guardar el archivo
  doc.save(`${form.value.title}_responses.pdf`);
};

const generateCSV = (responses) => {
  const headers = ['Estudiante', 'Curso', 'Fecha', 'Estado'];
  form.value.questions.forEach(q => headers.push(q.title));
  
  const rows = responses.map(response => {
    const row = [
      response.studentName,
      response.course,
      new Date(response.submittedAt).toLocaleString(),
      response.division
    ];
    
    form.value.questions.forEach(question => {
      const answer = response.answers.find(a => a.questionId === question.id);
      row.push(answer ? Array.isArray(answer.value) ? answer.value.join('; ') : answer.value : '');
    });
    
    return row;
  });

  // Añadir BOM para soporte de acentos en Excel
  const bom = '\uFEFF';
  return bom + [headers, ...rows].map(row => row.join(',')).join('\n');
};

const downloadFile = (content, filename, type) => {
  const blob = new Blob([content], { type });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = filename;
  link.click();
};
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-start mb-6">
      <div>
        <h1 class="text-2xl font-bold">{{ form.title }}</h1>
        <p class="text-gray-500">{{ form.description }}</p>
      </div>
      
      <!-- Download Menu -->
      <div class="relative">
        <button
          class="btn bg-white hover:bg-gray-50 text-gray-700 border flex items-center space-x-2"
          @click="showDownloadMenu = !showDownloadMenu"
        >
          <span>Descargar</span>
          <ChevronDownIcon class="w-5 h-5" />
        </button>
        <div
          v-if="showDownloadMenu"
          class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50"
        >
          <ul>
            <li>
              <button 
                class="w-full text-left px-4 py-2 hover:bg-gray-100"
                @click="handleDownload('csv')"
              >
                CSV
              </button>
            </li>
            <li>
              <button 
                class="w-full text-left px-4 py-2 hover:bg-gray-100"
                @click="handleDownload('json')"
              >
                JSON
              </button>
            </li>
            <li>
              <button 
                class="w-full text-left px-4 py-2 hover:bg-gray-100"
                @click="handleDownload('pdf')"
              >
                PDF
              </button>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <ResponseStats :responses="responses" />

    <div class="flex justify-between items-center mb-6">
      <ResponseFilters
        v-model:searchQuery="searchQuery"
        v-model:selectedCourse="selectedCourse"
        v-model:selectedDivision="selectedDivision"
      />
      
      <BulkActionsMenu
        :selected-count="selectedResponses.length"
        @action="handleBulkAction"
      />
    </div>

    <ResponsesTable
      :responses="filteredResponses"
      v-model:selected="selectedResponses"
      @view="handleViewResponse"
    />

    <ResponseDetails
      v-model="showResponseDetails"
      :response="selectedResponse"
      :form="form"
    />
  </div>
</template>