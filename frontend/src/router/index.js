import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreateResume from '@/views/CreateResume.vue'
import EditResume from '@/views/EditResume.vue'
import NotFound from '@/components/NotFound.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/new',
      name: 'new',
      component: CreateResume
    },
    {
      path: '/edit/:id',
      name: 'edit',
      component: EditResume
    },
    {
      path: '/:pathMatch(.*)*',
      redirect: '/error'
    },
    {
      path: '/error',
      name: 'error',
      component: NotFound
    }
  ]
})

export default router
