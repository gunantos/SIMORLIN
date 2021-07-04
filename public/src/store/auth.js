import { ls_admin, ls_auth, AUTH_LOGOUT, AUTH_ERROR, AUTH_REQUEST, AUTH_SUCCESS } from '@/constants.js'
import request from '@/lib/request.js'

const auth = {
    namespaced: true,
    state: () => ({
        token: localStorage.getItem(ls_auth) || '',
        status: '',
        isAdmin: localStorage.getItem(ls_admin) || ''
    }),
    mutations: {
        [AUTH_REQUEST]: (state) => {
            state.status = 'loading'
        },
        [AUTH_SUCCESS]: (state, token, isadmin) => {
            state.status = 'success'
            state.token = token
            state.isAdmin = isadmin
        },
        [AUTH_ERROR]: (state) => {
            state.status = 'error'
        },
        [AUTH_LOGOUT]: (state) => {
            state.status = ''
            state.token = ''
            state.isAdmin = ''
        }
    },
    actions: {
        [AUTH_REQUEST]: ({ commit }, user) => {
            console.log(user)
            return new Promise((reslove, reject) => {
                commit(AUTH_REQUEST)
                request({ url: 'auth', method: 'POST', auth: { username: user.username, password: user.password },  crossDomain: true }).then(resp => {
                    const data = resp.data
                    if (data.status) {
                        localStorage.setItem(ls_auth, data.token)
                        localStorage.setItem(ls_admin, data.isadmin)
                        commit(AUTH_SUCCESS, data.token, data.isAdmin)
                        reslove(resp)
                    } else {
                        commit(AUTH_ERROR, data.message)
                        localStorage.removeItem(ls_admin)
                        localStorage.removeItem(ls_auth)
                        reject(data.message)
                    }
                }).catch(err => {
                    commit(AUTH_ERROR, err)
                    localStorage.removeItem(ls_admin)
                    localStorage.removeItem(ls_auth)
                    reject(err)
                })
            })
        },
        [AUTH_LOGOUT]: ({ commit }) => {
            return new Promise((resolve) => {
                commit(AUTH_LOGOUT)
                localStorage.removeItem(ls_admin)
                localStorage.removeItem(ls_auth)
                resolve()
            })
        }
    },
    getters: {
        isAuthenticated: state => !!state.token,
        token: state => state.token,
        authStatus: state => state.status,
        isAdmin(state) {
            const adm = state.isAdmin
            if (adm) {
                return true
            } else {
                if (adm !== undefined && adm !== null && adm !== '' && adm !== 0) {
                    return true
                } else {
                    return false
                }
            }
        }
    }
}

export default auth