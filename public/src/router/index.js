import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '@/views/Login.vue'
import store from '@/store/index.js'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/tersedia',
    name: 'Tersedia',
    component: Home,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/kebutuhan',
    name: 'Kebutuhan',
    component: Home,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
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
const isAuthenticated = store.getters['auth/isAuthenticated']
const isAdmin = store.getters['auth/isAdmin']

router.beforeEach((to, from, next) => {
  if (to.name == 'Login' || to.name == 'login') {
    if (isAuthenticated) {
      if (isAdmin == 1 || isAdmin) {
        next({ name: 'Dashboard' })
      } else {
        next({ name: 'Home' })
      }
    } else {
      next()
    }
  } else {
    if (to.matched.some(record => record.meta.requireAuth)) {
      if (isAuthenticated) {
        if (to.matched.some(record => record.meta.is_admin)) {
          if (to.name == 'Login' || to.name == 'login') {
            if (isAdmin == 1 || isAdmin) {
              next({ name: 'Dashboard' })
            } else {
              next({ name: 'Home' })
            }
          } else {
            if (isAdmin == 1 || isAdmin) {
              next()
            } else {
              next({ name: 'Home' })
            }
          }
        } else if (to.matched.some(record => record.meta.is_user)) {
          if (isAdmin) {
            next({ name: 'Dashboard'})
          } else {
            next()
          }
        } else {
          next()
        }
      } else {
        next({
          path: '/login',
          params: { nextUrl: to.fullPath }
        })
      }
    } else {
      next()
    }
  }
})
export default router
