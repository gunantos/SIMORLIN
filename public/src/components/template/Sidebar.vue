<template>
  <v-navigation-drawer app floating v-model="sidebar" dark :src="gambar">
     <template v-slot:img="{ props }">
        <v-img
          :src="gambar"
          height="100%"
          width="100%"
          v-bind="props"
          gradient="to top right, rgba(43,168,224.8), rgba(75,129,195,.7)"
        ></v-img>
      </template>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title
          class="text-h4"
          style="text-align: center; font-weight: 600"
        >
          {{ appname }}
        </v-list-item-title>
        <v-list-item-subtitle> </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list dense nav dark>
      <div v-for="(item, inde) in items" :key="inde">
        <v-list-group v-if="issub(item)" no-action :prepend-icon="item.icon" color="white">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </template>
          <v-list-item
            v-for="(itm, ind) in item.sub"
            :key="ind"
            link
            dark
            color="white"
            :to="itm.path"
          >
            <v-list-item-title>{{ itm.title }}</v-list-item-title>
            <v-list-item-icon>
              <v-icon>{{ itm.icon }}</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
        <v-list-item v-else link :to="item.path">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </div>
    </v-list>
  </v-navigation-drawer>
</template>
<script>
import { APP_NAME } from "@/constants.js";
import gambar from '@/assets/dishubbandung.jpg'
export default {
  props: {},
  computed: {
    appname() {
      return APP_NAME;
    },
    sidebar: {
      get: function () {
        return this.$store.getters.valSidebar;
      },
      set: function (val) {
        this.$store.dispatch("set_sidebar", val);
      },
    },
    items() {
      return this.$store.getters.listMenu;
    },
  },
  data() {
    return {
      menu: null,
      gambar: gambar
    };
  },
  methods: {
    issub(item) {
      if (item.sub !== undefined) {
        if (Array.isArray(item.sub)) {
          if (item.sub.length > 0) {
            return true;
          }
        }
      }
      return false;
    },
  },
};
</script>
<style scoped>
.active {
  background-color: aliceblue;
}
</style>