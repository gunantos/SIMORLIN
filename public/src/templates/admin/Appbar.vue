<template>
  <v-app-bar app color="primary" dark>
    <v-app-bar-nav-icon @click="setSidebar()"></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-menu open-on-hover offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
          <v-icon>mdi-account</v-icon>
        </v-btn>
      </template>

      <v-list>
        <v-list-item link @click="goto('profile')">
          <v-list-item-icon style="padding-right: 0px; margin-right: 10px"
            ><v-icon>mdi-account</v-icon></v-list-item-icon
          >
          <v-list-item-title>Profile</v-list-item-title>
        </v-list-item>
        <v-list-item link @click="goto('logout')">
          <v-list-item-icon style="padding-right: 0px; margin-right: 10px"
            ><v-icon>mdi-logout</v-icon></v-list-item-icon
          >
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>
<script>
import { AUTH_LOGOUT } from "@/constants";
export default {
  computed: {},
  data() {
    return {};
  },
  methods: {
    setSidebar() {
      var sdbar = this.$store.getters.valSidebar;
      this.$store.dispatch("set_sidebar", !sdbar);
    },
    goto(val) {
      if (val == "profile") {
        this.$router.push({ path: "/profile" });
      } else if (val == "logout") {
        this.$store.dispatch("auth/" + AUTH_LOGOUT).then(() => {
          window.location.reload();
          return;
        });
      }
    },
  },
};
</script>
