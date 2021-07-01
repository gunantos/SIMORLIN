<template>
  <v-app>
    <Appbar />
    <v-main>
      <router-view />
    </v-main>
    <Footer />
  </v-app>
</template>

<script>
import Footer from "./Footer";
import Appbar from "./Appbar";
export default {
  name: "App",
  components: {
    Appbar,
    Footer,
  },
  data: () => ({
    //
  }),
};
</script>
