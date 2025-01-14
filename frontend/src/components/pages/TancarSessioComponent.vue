<template>
  <div class="logout-wrapper">
    <div class="logout-content">
      <h2 class="text-2xl font-semibold text-gray-800 text-center">Estàs segur que vols tancar la sessió?</h2>
      <p class="text-center text-gray-600 mt-4">Després de tancar sessió, hauràs d'iniciar sessió de nou per accedir.
      </p>
      <div class="buttons mt-6 flex justify-center space-x-4">
        <button @click="handleLogout"
          class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500">
          Tancar Sessió
        </button>
        <router-link to="/"
          class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 focus:ring-2 focus:ring-gray-400">
          Cancel·lar
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TancarSessio',
  methods: {
    async handleLogout() {
      try {
        // Send logout request to API
        const response = await fetch('http://pruebag10.daw.inspedralbes.cat/backend/public/api/logout', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Content-Type': 'application/json',
          },
        });

        if (!response.ok) {
          throw new Error('Error tancant la sessió. Si us plau, torna-ho a intentar.');
        }

        // Clear auth token and user info from localStorage
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');

        // Redirect to login page
        this.$router.push('/login');
        console.log('Sessió tancada correctament');
      } catch (error) {
        console.error(error.message || 'Error desconegut tancant sessió.');
      }
    },
  },
};
</script>

<style scoped>
.logout-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #f9fafb;
  padding: 20px;
}

.logout-content {
  background: white;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.buttons button,
.buttons a {
  min-width: 120px;
  text-align: center;
}
</style>