<template>
  <v-card :color="color" dark>
    <div class="d-flex flex-no-wrap justify-space-between">
      <div>
        <v-card-title class="text-h5" v-text="title"></v-card-title>

        <v-card-actions>
          <h1>{{ ttl }}</h1>
        </v-card-actions>
      </div>

      <v-avatar class="ma-3" size="125" tile>
        <v-img :src="img"></v-img>
      </v-avatar>
    </div>
  </v-card>
</template>
<script>
export default {
  props: {
    title: String,
    ttl: Number,
    img: String,
    color: String,
  },
};
</script>