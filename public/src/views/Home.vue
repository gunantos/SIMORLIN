<template>
  <v-container style="padding: 10px">
    <v-row>
      <v-col v-for="(item, i) in items" :key="i" cols="12" sm="6">
        <top
          :title="item.title"
          :ttl="item.ttl"
          :img="item.img"
          :color="item.color"
        ></top>
      </v-col>
    </v-row>
    <v-img :src="image" style="margin-top: 20px"></v-img>
  </v-container>
</template>

<script>
import Top from "@/components/dashboard/Top";
import image from "@/assets/img/bupati-bandung.jpg";
export default {
  name: "Home",
  components: {
    Top,
  },
  data() {
    return {
      image: image,
      items: [
        {
          title: "Kebutuhan",
          ttl: 0,
          img: "",
          color: "#F9A825",
        },
        {
          title: "Tersedia",
          ttl: 0,
          img: "",
          color: "#26A69A",
        },
      ],
    };
  },
};
</script>
