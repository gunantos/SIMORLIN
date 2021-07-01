<template>
  <v-footer dark padless>
    <v-card flat width="100%" tile class="text-center" :color="color">
      <v-card-text class="white--text">
        <v-row>
          <v-col md="4">
            <v-img max-height="100" max-width="250" :src="logo" />
            <div class="text-left">
              Mewujudkan Kabupaten Bandung melalui penyediaan layanan
              transportasi yang handal, modern, dan berdaya saing internasional,
              dengan angkutan publik sebagai layanan utama
            </div>
          </v-col>
          <v-col md="4" class="text-left">
            <h2><u>Link Terkait</u></h2>
          </v-col>
          <v-col md="4" class="text-left">
            <h2><u>Kontak Kami</u></h2>
            <div class="pt-4">
              <v-icon small>mdi-map-marker</v-icon> Jl. Raya Soreang Km. 17
            </div>
            <div class="pt-4">
              <v-icon small>mdi-phone</v-icon> + 021 88345368
            </div>
            <div class="pt-4">
              <v-icon small>mdi-email</v-icon> dishub@bandungkab.go.id
            </div>
          </v-col>
        </v-row>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-text class="white--text">
        {{ new Date().getFullYear() }} — <strong>SIMORLIN</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
import footerLogo from "@/assets/footer-logo.png";
import templates from "@/templates.js";
export default {
  data: () => ({
    icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
    logo: footerLogo,
    color: templates.footerColor,
  }),
};
</script>