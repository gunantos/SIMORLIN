<template>
  <div>
    <app-admin v-if="isLogin" :islogin="isLogin"></app-admin>
    <app-quest :islogin="isLogin" v-else></app-quest>
  </div>
</template>
<script>
import appAdmin from "./admin/App";
import appQuest from "./quest/App";
export default {
  components: {
    appAdmin,
    appQuest,
  },
  computed: {
    isLogin() {
      return this.$store.getters['auth/isAuthenticated']
    },
  },
  data() {
    return {};
  },
};
</script>