<template>
  <v-app>
    <Appbar />
    <Sidebar />
    <v-main>
      <router-view />
    </v-main>
    <Footer />
  </v-app>
</template>

<script>
import Footer from "./Footer";
import Appbar from "./Appbar";
import Sidebar from "@/components/template/Sidebar"
export default {
  name: "App",
  components: {
    Appbar,
    Footer,
    Sidebar
  },
  data: () => ({
    //
  }),
};
</script>
