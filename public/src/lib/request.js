import axios from 'axios'
import * as configs from '@/constants.js'
import store from '@/store'
import { AUTH_LOGOUT } from '@/constants.js'

const token = localStorage.getItem(configs.ls_auth)

const request = axios.request({
    baseURL: configs.API_URL,
    timeout: configs.timeout_request
})
request.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

request.interceptors.request.use(
  config => {
    // do something before request is sent
    if (token !== undefined && token !== null && token !== 'null' && token !== '') {
      config.headers.common['Authorization'] = 'Bearer ' + token
    }
    return config
  },
  error => {
    console.log(error) // for debug
    return Promise.reject(error)
  }
)

request.interceptors.response.use((response) => {
    return response;
}, error => {
    if (error.response) {
        if (error.response.status) {
            if (error.response.status == 401) {
                store.dispatch('auth/'+ AUTH_LOGOUT).then(() => {
                    location.reload()
                    return;
                })
            }
        }
    }
    return Promise.reject(error)
})
export default request