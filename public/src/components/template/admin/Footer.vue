<template>
  <v-footer dark padless>
    <v-card flat width="100%" tile class="text-right" :color="color">
      <v-divider></v-divider>
      <v-card-text class="white--text">
        {{ new Date().getFullYear() }} — <strong>SIMORLIN</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
import templates from "@/templates.js";
export default {
  data: () => ({
    color: templates.footerColor,
  }),
};
</script>