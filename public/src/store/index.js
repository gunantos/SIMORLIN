import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    sidebar: true,
    listMenu: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard', path: '/dashboard' },
      { title: 'Map', icon: 'mdi-map-search', path: '/map' },
      {
        title: 'Input', icon: 'mdi-table-edit', path: '/input', sub: [
          { title: 'Kebutuhan', icon: 'mdi-map-search', path: '/input/kebutuhan' },
        { title: 'Tersedia', icon: 'mdi-map-marker-circle', path: '/input/tersedia' }
        ]
      },
      {
        title: 'Data', icon: 'mdi-ballot', path: '/data', sub: [
          { title: 'Kecamatan', icon: '', path: '/data/kecamatan' },
          { title: 'Desa/Kelurahan', icon: '', path: '/data/desa' },
          { title: 'Jalan', icon: '', path: '/data/jalan' },
          { title: 'Ruas Jalan', icon: '', path: '/data/ruas' },
          { title: 'Arah Jalan', icon: '', path: '/data/arah' },
          { title: 'Perlengkapan', icon: '', path: '/data/perlengkapan' }
        ]
      },
      {
        title: 'Pengaturan', icon: 'mdi-cog', path: '/setting', sub: [
          { title: 'Gambar Login', icon: 'mdi-cookie', path: '/setting/login-gambar' },
          { title: 'Users', icon: 'mdi-account', path: '/setting/user' }
      ]}
    ]
  },
  mutations: {
    setSidebar(state, val) {
      state.sidebar = val
      return val
    }
  },
  actions: {
    set_sidebar({ commit }, val) {
      commit('setSidebar', val)
      return true
    }
  },
  getters: {
    valSidebar(state) {
      return state.sidebar
    },
    listMenu(state) {
      return state.listMenu
    }
  },
  modules: {
    auth: auth
  }
})
