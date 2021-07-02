<template>
  <v-app>
    <Appbar v-if="islogin" />
    <v-main>
      <router-view />
    </v-main>
    <Footer v-if="islogin" />
  </v-app>
</template>

<script>
import Footer from "./Footer";
import Appbar from "./Appbar";
export default {
  name: "App",
  props: {
    islogin: {
      default: false,
      type: Boolean
    }
  },
  components: {
    Appbar,
    Footer,
  },
  data: () => ({
    //
  }),
};
</script>
