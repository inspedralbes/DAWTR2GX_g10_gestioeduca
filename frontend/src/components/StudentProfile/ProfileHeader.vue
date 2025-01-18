<template>
  <header class="sticky top-0 z-50 bg-white shadow-md w-full">
    <nav class="flex items-center justify-between px-6 py-4 lg:px-8 lg:py-6" aria-label="Global">
      <!-- Logo -->
      <router-link to="/" class="-m-1.5 p-1.5">
          <span class="sr-only">Grupify</span>
          <img class="h-8 w-auto" src="../../../public/img/icono.png" alt="Logo">
        </router-link>

      <!-- Botón del menú móvil -->
      <div class="flex lg:hidden">
        <button @click="toggleMenu" type="button"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
          <span class="sr-only">Abrir menú</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Navegación de escritorio -->
      <div class="hidden lg:flex lg:flex-1 lg:justify-end space-x-8">
        <button @click="$emit('show-asignatures')" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">
          Assignatures
        </button>
        <button @click="$emit('show-enquestes')" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">
          Enquestes
        </button>
        <button @click="redirectToLogout" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">
          Tancar Sessió
        </button>
      </div>
    </nav>

    <!-- Menú móvil -->
    <div v-show="isMenuOpen" class="lg:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <button @click="$emit('show-asignatures')"
          class="block w-full text-left px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-indigo-600">
          Assignatures
        </button>
        <button @click="$emit('show-enquestes')"
          class="block w-full text-left px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-indigo-600">
          Enquestes
        </button>
        <button @click="redirectToLogout"
          class="block w-full text-left px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-indigo-600">
          Tancar Sessió
        </button>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'ProfileHeader',
  data() {
    return {
      isMenuOpen: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    redirectToLogout() {
      // Redirige al usuario a la página de cierre de sesión
      this.$router.push('/tancar-sessio');
    },
  },
};
</script>

<style scoped>
header {
  height: 80px;
}

nav {
  width: 100%;
}

@media (max-width: 1024px) {
  nav {
    padding: 0 20px;
  }
}

@media (min-width: 1025px) {
  .lg\\:px-8 {
    padding-left: 40px;
    padding-right: 40px;
  }
}

.hidden.lg\\:flex > button {
  margin-right: 20px;
}

.lg\\:hidden {
  padding: 10px;
}
</style>
