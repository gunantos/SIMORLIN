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
    <div id="chart" style="margin-top: 20px; margin-bottom: 20px">
        <apexchart type="bar" height="350" :options="optionsBar" :series="chartdataBar"></apexchart>
   </div>
    <v-img :src="image" style="margin-top: 20px"></v-img>
  </v-container>
</template>

<script>
import Top from "@/components/dashboard/Top";
import image from "@/assets/img/bupati-bandung.jpg";
import VueApexCharts from 'vue-apexcharts'
import request from '@/lib/request'
export default {
  name: "Home",
  components: {
    Top,
    apexchart: VueApexCharts,
  },
  computed: {
      optionsBar ()  {
        return { 
          chart: {
            id: 'vuechart-example'
          },
          xaxis: {
            categories: this.category
          }
      }
    }
  },
  data() {
    return {
      image: image,
      isLoading: false,
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
      category: [],
     chartdataBar: [{
            name: 'tersedia',
            data: []
          },
          {
            name: 'dibutuhkan',
            data: []
          }]
    };
  },
  mounted() {
    this.loadData()
  },
  methods: {
    async loadData() {
      await this.getTop()
      await this.getGrafik()
    },
    getTop() {
      request({ url: 'dashboard/top', methods: 'GET' }).then(resp => {
        if (resp.data.status) {
          this.items[0].ttl = parseInt(resp.data.dibutuhkan)
          this.items[1].ttl = parseInt(resp.data.tersedia)
        } else {
          this.items[0].ttl = 0
          this.items[1].ttl = 0
        }
      }).catch(() => {
        this.items[0].ttl = 0
          this.items[1].ttl = 0
      })
    },
    getGrafik() {
      request({ url: 'dashboard/grafik', methods: 'GET' }).then(resp => {
        if (resp.data.status) {
          const dat = resp.data.data
          this.optionsBar.xaxis.categories = []
          this.chartdataBar = [{
            name: 'tersedia',
            data: []
          },
          {
            name: 'dibutuhkan',
            data: []
          }]
          var x = []
          dat.forEach(el => {
            x.push(el.nama_kecamatan)
            this.chartdataBar[0].data.push(parseInt(el.tersedia))
            this.chartdataBar[1].data.push(parseInt(el.tersedia))
          })
          this.category = x
        }
      })
    }
  }
};
</script>
