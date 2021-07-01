<template>
  <div>
    <admin-footer v-if="isLogin"></admin-footer>
    <quest-footer v-else></quest-footer>
  </div>
</template>
<script>
import adminFooter from "@/components/template/admin/Footer";
import questFooter from "@/components/template/quest/Footer";

export default {
  components: {
    adminFooter,
    questFooter,
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
