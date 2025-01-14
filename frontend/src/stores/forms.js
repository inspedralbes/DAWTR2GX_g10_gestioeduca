// stores/forms.js

import { defineStore } from 'pinia';

export const useFormsStore = defineStore('forms', {
  state: () => ({
    forms: [],  // Todos los formularios
    currentForm: null,  // El formulario específico
    questionsAndAnswers: null,  // Preguntas y respuestas del formulario
  }),

  actions: {
    async loadForms() {
      try {
        const response = await fetch('http://pruebag10.daw.inspedralbes.cat/backend/public/api/forms', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Accept': 'application/json',
          },
        });

        if (!response.ok) throw new Error('Error al cargar los formularios');
        this.forms = await response.json();
      } catch (error) {
        console.error('Error al cargar los formularios:', error);
        throw error;
      }
    },

    async loadFormById(formId) {
      if (!formId) throw new Error('ID del formulario no proporcionado');

      try {
        const response = await fetch(`http://pruebag10.daw.inspedralbes.cat/backend/public/api/forms/${formId}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Accept': 'application/json',
          },
        });

        if (!response.ok) throw new Error(`Error al cargar el formulario con ID ${formId}`);
        const form = await response.json();
        this.currentForm = form;
        return form;
      } catch (error) {
        console.error(`Error al cargar el formulario con ID ${formId}:`, error);
        throw error;
      }
    },

    async getFormQuestionsAndAnswers(formId) {
      if (!formId) throw new Error('ID del formulario no proporcionado');

      try {
        const response = await fetch(`http://pruebag10.daw.inspedralbes.cat/backend/public/api/forms/${formId}/questions`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Accept': 'application/json',
          },
        });

        if (!response.ok) throw new Error('Error al cargar las preguntas y respuestas');
        const data = await response.json();
        this.questionsAndAnswers = data.questions;  // Asumimos que 'questions' está en la respuesta
        return data.questions;
      } catch (error) {
        console.error('Error al cargar preguntas y respuestas:', error);
        throw error;
      }
    },
  },
});
