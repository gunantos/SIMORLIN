import Vue from 'vue'
import { ls_auth, ls_admin } from '@/constants.js'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      quest: true
    }
  },
  {
    path: '/tersedia',
    name: 'Tersedia',
    component: Home,
    meta: {
      quest: true
    }
  },
  {
    path: '/kebutuhan',
    name: 'Kebutuhan',
    component: Home,
    meta: {
      quest: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Home,
    meta: {
      quest: true
    }
  },
  {
    path: '/admin/',
    alias: '/admin',
    name: 'Dashboard',
    component: Home,
    meta: {
      requireAuth: true,
      is_admin: true
    }
  },
  {
    path: '/admin/input',
    name: 'Input',
    component: Home,
    meta: {
      requireAuth: true,
      is_admin: true
    }
  },
  {
    path: '/admin/report',
    name: 'Report',
    component: Home,
    meta: {
      requireAuth: true,
      is_admin: true
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

const token = localStorage.getItem(ls_auth)
const isAdmin = localStorage.getItem(ls_admin)

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requireAuth)) {
    if (token == null || token == '') {
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    } else {
      if (to.matched.some(record => record.meta.is_admin)) {
        if (isAdmin == 1) {
           next()
        } else {
          next({ name: 'Home' })
         }
      } else {
        next()
      }
    }
  } else {
    next()
  }
})
export default router
