<template>
  <header class="sticky top-0 z-50 bg-white shadow-md">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
        <router-link to="/" class="-m-1.5 p-1.5">
          <span class="sr-only">Grupify</span>
          <img class="h-8 w-auto" src="../../../public/img/icono.png" alt="Logo">
        </router-link>
      </div>
      <!-- Mobile menu button -->
      <div class="flex lg:hidden">
        <button @click="toggleMenu" type="button"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
          <span class="sr-only">Menú principal</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <!-- Desktop navigation -->
      <div class="hidden lg:flex lg:flex-1 lg:justify-end space-x-4">
        <button @click="$emit('show-contact')" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Contacte</button>
        <router-link to="/login" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Començar</router-link>
      </div>
    </nav>

    <!-- Mobile menu -->
    <div v-show="isMenuOpen" class="lg:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <button @click="handleContactClick"
          class="block w-full text-left px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-indigo-600">
          Contacte
        </button>
        <router-link to="/login"
          class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-indigo-600"
          @click="isMenuOpen = false">
          Començar
        </router-link>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'NavBar',
  data() {
    return {
      isMenuOpen: false
    }
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    handleContactClick() {
      this.isMenuOpen = false;
      this.$emit('show-contact');
    }
  }
}
</script>