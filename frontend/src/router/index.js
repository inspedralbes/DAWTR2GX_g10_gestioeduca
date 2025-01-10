import { createRouter, createWebHistory } from 'vue-router';
import LandingComponent from '@/components/Landing/LandingComponent.vue';
import LoginView from '../views/LoginView.vue';
import GroupList from '../views/Groups/GroupList.vue';
import FormList from '../views/Forms/FormList.vue';
import StudentDashboard from '@/components/student/StudentDashboard.vue';
import Register from '@/components/Login/Register.vue';
import FormResponses from '@/views/Forms/FormResponses.vue';
import StudentList from '../views/Students/StudentList.vue'
import StudentProfile from '../views/Students/StudentProfile.vue'
import CreateForm from '@/views/CreateForm.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landing',
      component: LandingComponent,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/alumnos',
      name: 'StudentList',
      component: StudentList,
    },
    {
      path: '/alumnos/:id',
      name: 'StudentProfile',
      component: StudentProfile
    },
    {
      path: '/profesores',
      name: 'TeacherViewList',
      component: () =>import ('@/views/TeachersView/TeacherViewList.vue'),
    },
    {
      path: '/profesores/:id',
      name: 'TeacherViewProfile',
      component: () =>import ('@/views/TeachersView/TeacherViewProfile.vue'),
    },
    {
      path: '/crear-formulario',
      name: 'CreateForm',
      component: CreateForm,
    },
    {
      path: '/formularios/:id/respuestas',
      name: 'FormResponses',
      component: FormResponses,
    },
    {
      path: '/brain',
      name: 'brain',
      component: () => import('@/components/Brain/ChatInterface.vue'),
    },
    {
      path: '/student',
      component: StudentDashboard,
      meta: { requiresAuth: true },
      children: [
        {
          path: '',
          redirect: '/student/dashboard'
        },
        {
          path: 'dashboard',
          name: 'studentHome',
          component: () => import('@/components/student/StudentHome.vue')
        },
        {
          path: 'group',
          name: 'studentGroup',
          component: () => import('@/components/student/StudentGroup.vue')
        },
        {
          path: 'forms',
          name: 'studentForms',
          component: () => import('@/components/student/StudentForms.vue')
        }
      ]
    },
    {
      path: '/formularios',
      name: 'FormList',
      component: FormList,
      meta: { requiresAuth: true },
    },
    {
      path: '/teacherProfile/:id',
      name: 'teacherProfile',
      component: () => import('../components/TeacherProfile/TeacherProfileComponent.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/groupsProfile/:id',
      name: 'groupsProfile',
      component: () => import('../components/GroupsProfile/GroupProfileComponent.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/studentsList',
      name: 'studentsList',
      component: () => import('../components/modules/user/StudentsListComponent.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/teachersList',
      name: 'teachersList',
      component: () => import('../components/modules/user/TeachersListComponent.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/groupsList',
      name: 'groupsList',
      component: () => import('../components/modules/user/GroupsListComponent.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/grupos',
      name: 'GroupList',
      component: GroupList,
      meta: { requiresAuth: true },
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/DashboardView.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/formCecs',
      name: 'formCecs',
      component: () => import('../components/FormCecs/FormCecsComponent.vue'),
    },
    {
      path: '/sociogram',
      name: 'sociogramTest',
      component: () => import('../components/Sociogram/SociogramTest.vue'),
    },
    {
      path: '/tancar-sessio',
      name: 'tancarSessio',
      component: () => import('../components/pages/TancarSessioComponent.vue'),
      meta: { requiresAuth: true },
    },
    //per verificar component createGroup
    {
      path: '/createGroup',
      name: 'createGroup',
      component: () => import('../views/Groups/CreateGroup.vue'),
    },
  ],
});

// Global navigation guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('user'); // Verifica si hay datos del usuario
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login'); // Redirige al login si no está autenticado
  } else {
    next(); // Permite el acceso
  }
});

export default router;