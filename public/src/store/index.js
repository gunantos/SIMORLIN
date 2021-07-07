import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    sidebar: true,
    listMenu: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard', path: '/admin/dashboard' },
      { title: 'Kebutuhan', icon: 'mdi-map-search', path: '/admin/kebutuhan' },
      { title: 'Tersedia', icon: 'mdi-map-marker-circle', path: '/admin/tersedia' },
      {
        title: 'Input', icon: 'mdi-table-edit', path: '/admin/input', sub: [
          { title: 'Kebutuhan', icon: 'mdi-map-search', path: '/admin/input/kebutuhan' },
        { title: 'Tersedia', icon: 'mdi-map-marker-circle', path: '/admin/input/tersedia' }
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
