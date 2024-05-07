import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        guard: 'auth'
      }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue'),
      meta: {
        guard: 'guest'
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/RegisterView.vue'),
      meta: {
        guard: 'guest'
      }
    },
    {
      path: '/profile',
      name: 'profile-me',
      component: () => import('../views/ProfileView.vue'),
      meta: {
        guard: 'auth'
      }
    },
    {
      path: '/profile/:username',
      name: 'profile-user',
      component: () => import('../views/ProfileView.vue'),
      meta: {
        guard: 'auth'
      }
    },
    {
      path: '/create-post',
      name: 'create-post',
      component: () => import('../views/CreatePostView.vue'),
      meta: {
        guard: 'auth'
      }
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/NotFoundView.vue')
    }
  ]
})

router.beforeEach((to, from) => {
  if (localStorage.getItem('token') && to.meta.guard == 'guest') {
    return { name: 'profile-me' }
  }

  if (!localStorage.getItem('token') && to.meta.guard == 'auth') {
    return { name: 'login' }
  }
})

export default router
