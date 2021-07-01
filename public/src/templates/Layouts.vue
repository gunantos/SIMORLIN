<template>
  <div>
    <app-admin v-if="isLogin"></app-admin>
    <app-quest v-else></app-quest>
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
      return false;
    },
  },
  data() {
    return {};
  },
};
</script>