<template>
  <div>
    <admin-header v-if="isLogin"></admin-header>
    <quest-header v-else></quest-header>
  </div>
</template>
<script>
import adminHeader from "@/components/template/admin/Appbar";
import questHeader from "@/components/template/quest/Appbar";

export default {
  components: {
    adminHeader,
    questHeader,
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
