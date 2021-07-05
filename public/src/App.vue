<template>
  <layouts />
</template>

<script>
import layouts from "@/templates/Layouts";
import request from '@/lib/request.js'
import { ls_admin, ls_auth, AUTH_LOGOUT, AUTH_SUCCESS } from '@/constants.js'
export default {
  name: "App",
  components: {
    layouts,
  },
  created () {
    request({ url: '/verifikasi', method: 'post' }).then(resp => {
      const data = resp.data
      if (data.status == true) {
        console.log(data.status)
        localStorage.setItem(ls_auth, data.token)
        localStorage.setItem(ls_admin, data.isadmin)
        this.$store.commit('auth/'+ AUTH_SUCCESS, data.token, data.isAdmin)
      } else {
        this.$store.dispatch('auth/'+ AUTH_LOGOUT)
      }
    }).catch(err => {
      console.log(err)
      this.$store.dispatch('auth/'+ AUTH_LOGOUT)
    })
  },
  data() {
    return {};
  },
};
</script>
