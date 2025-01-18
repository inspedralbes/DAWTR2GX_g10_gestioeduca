import { defineStore } from 'pinia';

export const useTeachersStore = defineStore('teachers', {
    state: () => ({
        teachers: [], // Aquí guardamos el listado profesores
        loading: false, // Puedes usarlo para mostrar una carga mientras se obtienen los datos
        error: null, // Para manejar posibles errore
    }),
    actions: {
        async fetchTeachers() {
            this.loading = true; // Comienza la carga
            try {
                const response = await fetch('http://grupify.daw.inspedralbes.cat/backend/public/api/get-teachers');

                if (!response.ok) {
                    throw new Error(`Error: ${response.divisionText}`);
                }

                const data = await response.json();
                this.teachers = data; // Guarda los teachers en el estado
                //console.log('Datos recibidos de la API:', data);
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching teachers:', error);
            } finally {
                this.loading = false; // Termina la carga
            }
        },
        getTeachersById(id) {
            //console.log('Buscando profesor con ID:', id, typeof id);
            const found = this.teachers.find(teacher => teacher.id === Number(id));
           //console.log('Profesor encontrado:', found);
            return found;
        }
    },
    getters: {
        teachersCount: (state) => {
            return state.teachers.length;
        },
    },
});
