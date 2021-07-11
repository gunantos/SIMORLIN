import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '@/views/Login.vue'
import store from '@/store/index.js'
import Map from '@/views/Map.vue'
import Kecamatan from '@/views/data/Kecamatan.vue'
import Desa from '@/views/data/Desa.vue'
import Jalan from '@/views/data/Jalan.vue'
import Ruas from '@/views/data/Ruas.vue'
import Arah from '@/views/data/Arah.vue'
import Perlengkapan from '@/views/data/Perlengkapan.vue'
import Tersedia from '@/views/input/Tersedia.vue'
import Kebutuhan from '@/views/input/Kebutuhan.vue'
import GambarLogin from '@/views/LoginGambar'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    alias: '/dashboard',
    name: 'Home',
    component: Home,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
   {
    path: '/dashboard',
    name: 'Dashboard',
    component: Home,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/map',
    name: 'Map',
    component: Map,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/input/kebutuhan',
    name: 'InputKebutuhan',
    component: Kebutuhan,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/input/tersedia',
    name: 'InputTersedia',
    component: Tersedia,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/kecamatan',
    name: 'DataKecamatan',
    component: Kecamatan,
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/desa',
    component: Desa,
    name: 'DataDesa',
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/jalan',
    component: Jalan,
    name: 'DataJalan',
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/ruas',
    component: Ruas,
    name: 'DataRuas',
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/arah',
    component: Arah,
    name: 'DataArah',
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/data/perlengkapan',
    component: Perlengkapan,
    name: 'DataPerlengkapan',
    meta: {
      requireAuth: true,
      is_user: true
    }
  },
  {
    path: '/setting/login-gambar',
    component: GambarLogin,
    name: 'SettingGambarLogin',
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
            next()
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
