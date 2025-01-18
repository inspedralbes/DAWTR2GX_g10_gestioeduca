<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import {
  HomeIcon,
  DocumentTextIcon,
  UserGroupIcon,
  UsersIcon,
  ArrowLeftStartOnRectangleIcon,
  ChatBubbleLeftRightIcon,
  HeartIcon,
  ChartBarIcon,
  Bars3Icon,
  XMarkIcon,
  SparklesIcon
} from '@heroicons/vue/24/outline'

const router = useRouter()
const isMobileMenuOpen = ref(false)

const navigation = [
  { name: 'Dashboard', icon: HomeIcon, route: '/dashboard' },
  { name: 'Formularios', icon: DocumentTextIcon, route: '/formularios' },
  { name: 'Alumnos', icon: UserGroupIcon, route: '/alumnos' },
  { name: 'Grupos', icon: UsersIcon, route: '/grupos' },
  { name: 'Comunicación', icon: ChatBubbleLeftRightIcon, route: '/comunicacion' },
  { name: 'Brain', icon: SparklesIcon, route: '/brain' },
  { name: 'Tancar sessió', icon: ArrowLeftStartOnRectangleIcon, route: '/tancar-sessio' }
]

const navigateTo = (route) => {
  router.push(route)
  isMobileMenuOpen.value = false
}

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}
</script>

<template>
  <div>
    <!-- Mobile menu button -->
    <div class="fixed top-0 left-0 right-0 z-40 bg-white h-16 flex items-center lg:hidden border-b px-4">
      <button 
        class="p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100"
        @click="toggleMobileMenu"
      >
        <Bars3Icon v-if="!isMobileMenuOpen" class="h-6 w-6" />
        <XMarkIcon v-else class="h-6 w-6" />
      </button>
      <h1 class="text-xl font-bold text-primary ml-4">Panel Docente</h1>
    </div>

    <!-- Sidebar for desktop -->
    <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white border-r">
      <div class="flex-1 flex flex-col min-h-0">
        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-primary">
          <h1 class="text-xl font-bold text-white">Panel Docente</h1>
        </div>
        <nav class="flex-1 px-2 py-4 space-y-1">
          <button
            v-for="item in navigation"
            :key="item.name"
            @click="navigateTo(item.route)"
            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 w-full"
            :class="{ 'bg-primary/10 text-primary': $route.path === item.route }"
          >
            <component :is="item.icon" class="w-5 h-5 mr-3" />
            {{ item.name }}
          </button>
        </nav>
      </div>
    </div>

    <!-- Mobile menu -->
    <div
      v-if="isMobileMenuOpen"
      class="lg:hidden fixed inset-0 z-30 bg-white"
    >
      <div class="flex items-center h-16 flex-shrink-0 px-4 bg-primary">
        <h1 class="text-xl font-bold text-white">Panel Docente</h1>
      </div>
      <nav class="px-2 py-4 space-y-1">
        <button
          v-for="item in navigation"
          :key="item.name"
          @click="navigateTo(item.route)"
          class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 w-full"
          :class="{ 'bg-primary/10 text-primary': $route.path === item.route }"
        >
          <component :is="item.icon" class="w-5 h-5 mr-3" />
          {{ item.name }}
        </button>
      </nav>
    </div>
  </div>
</template>