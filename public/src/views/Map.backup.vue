<template>
<v-container>
  <l-map
    :zoom.sync="zoom"
    :options="mapOptions"
    :center="center"
    :bounds="bounds"
    :min-zoom="minZoom"
    :max-zoom="maxZoom"
    style="height: 100%; width: 100%"
  >
    <l-control-layers
      :position="layersPosition"
      :collapsed="false"
      :sort-layers="true"
    />
    <l-tile-layer
      v-for="tileProvider in tileProviders"
      :key="tileProvider.name"
      :name="tileProvider.name"
      :visible="tileProvider.visible"
      :url="tileProvider.url"
      :attribution="tileProvider.attribution"
      :token="token"
      layer-type="base"
    />
    <l-control-zoom :position="zoomPosition" />
    <l-control-attribution
      :position="attributionPosition"
      :prefix="attributionPrefix"
    />
    <l-control-scale :imperial="imperial" />
    <l-layer-group
      v-for="item in tersedia"
      :key="item.id"
      :visible.sync="item.visible"
      layer-type="overlay"
      name="TERSEDIA"
    >
        <l-marker
          v-for="marker in item.markers"
          :key="marker.id"
          :visible="marker.visible"
          :draggable="marker.draggable"
          :lat-lng="marker.position"
          @click="alert(marker)"
        >
      <l-popup :content="marker.tooltip" />
      <l-tooltip :content="marker.tooltip" />
      </l-marker>
      <l-polyline
        :lat-lngs="item.polyline.points"
        :visible="item.polyline.visible"
        @click="alert(item.polyline)"
      />
    </l-layer-group>
    <l-layer-group
      v-for="item in kebutuhan"
      :key="item.id"
      :visible.sync="item.visible"
      layer-type="overlay"
      name="KEBUTUHAN"
    >
        <l-marker
          v-for="marker in item.markers"
          :key="marker.id"
          :visible="marker.visible"
          :draggable="marker.draggable"
          :lat-lng="marker.position"
          @click="kebutuhanClick(item)"
          :icon="markerspng"
        >
        <l-popup :content="marker.tooltip" />
        <l-tooltip :content="marker.tooltip" />
      </l-marker>
      <l-polyline
        :lat-lngs="item.polyline.points"
        :visible="item.polyline.visible"
        @click="kebutuhanClick(item)"
      />
    </l-layer-group>
  </l-map>
  </v-container>
</template>
<script>
import { latLngBounds, icon } from "leaflet";
import markerspng from '@/assets/markers.png'
import {
  LMap,
  LTileLayer,
  LMarker,
  LPolyline,
  LLayerGroup,
  LTooltip,
  LPopup,
  LControlZoom,
  LControlAttribution,
  LControlScale,
  LControlLayers,
} from "vue2-leaflet";
const tileProviders = [
  {
    name: "OpenStreetMap",
    visible: true,
    attribution:
      '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
  },
  {
    name: "OpenTopoMap",
    visible: false,
    url: "https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",
    attribution:
      'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
  },
];
import request from '@/lib/request.js'
export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPolyline,
    LLayerGroup,
    LTooltip,
    LPopup,
    LControlZoom,
    LControlAttribution,
    LControlScale,
    LControlLayers,
  },
  data() {
    return {
      center: [-7.0157722, 107.5550281],
      loading: false,
      opacity: 0.6,
      markerspng: icon({
        iconUrl: markerspng,
        iconSize: [32, 37],
        iconAnchor: [16, 17]
      }),
      token: "your token if using mapbox",
      mapOptions: {
        zoomControl: false,
        attributionControl: false,
        zoomSnap: true,
      },
      zoom: 3,
      minZoom: 1,
      maxZoom: 20,
      zoomPosition: "topleft",
      attributionPosition: "bottomright",
      layersPosition: "topright",
      attributionPrefix: "Vue2Leaflet",
      imperial: false,
      Positions: ["topleft", "topright", "bottomleft", "bottomright"],
      tileProviders: tileProviders,
      markers: [
        {
          id: "m1",
          position: { lat: -7.0157722, lng: 107.5550281 },
          tooltip: "tooltip for marker1",
          draggable: true,
          visible: true,
        },
      ],
      tersedia: [],
      kebutuhan: [],
      modalKebutuhan: false,
      modalTersedia:false,
      itemSelectKebutuhan: {},
      itemSelectTersedia: {},
      polylines: [
        {
          id: "p1",
          points: [
            { lat: 37.772, lng: -122.214 },
            { lat: 21.291, lng: -157.821 },
            { lat: -18.142, lng: -181.569 },
            { lat: -27.467, lng: -206.973 },
          ],
          visible: true,
        },
      ],
      bounds: latLngBounds(
        { lat: -7.0194419, lng: 107.5610011 },
        { lat: -6.9946788, lng: 107.5634318 }
      ),
    };
  },
  mounted() {
    this.loadData() 
  },
  methods: {
    async loadData() {
      await this.loadTersedia()
      await this.loadKebutuhan()
    },
    kebutuhanClick(item) {
      this.modalKebutuhan = true
      this.itemSelectKebutuhan = item
    },
    alert(item) {
      alert("this is " + JSON.stringify(item));
    },
    addMarker: function () {
      const newMarker = {
        position: { lat: 50.5505, lng: -0.09 },
        draggable: true,
        visible: true,
      };
      this.markers.push(newMarker);
    },
    removeMarker: function (index) {
      this.markers.splice(index, 1);
    },
    loadTersedia() {
      this.loading = true
      this.tersedia = []
      var hasil = []
      request({ url: 'tersedia?size=-1', method: 'GET'}).then(res => {
        const data = res.data
        if (data.status) {
          data.data.forEach(el => {
            const ind = hasil.findIndex(p => p.id_ruas_jalan == el.id_ruas_jalan)
            var ruas = {}
            if (ind > -1) {
              ruas.id_ruas_jalan = el.id_ruas_jalan
              ruas.nama_ruas_jalan = el.nama_ruas_jalan
              ruas.markers.push(
                {
                  position: {
                    lat: el.altitude,
                    lng: el.longitude
                  },
                  tooltip: el.nama_jalan,
                  draggable: false,
                  visible: true,
                  gambar_koordinat: el.gambar_koordinat,
                  gambar_rambu: el.gambar_rambu,
                  nama_arah_jalan: el.nama_arah_jalan,
                  kode_desa: el.kode_desa,
                  kelurahan: el.kelurahan,
                  kode_kecamatan: el.kode_kecamatan,
                  kondisi: el.kondisi,
                  nama_desa: el.nama_desa,
                  nama_jalan: el.nama_jalan,
                  nama_kecamatan: el.nama_kecamatan,
                  nama_perlengkapan: el.nama_perlengkapan,
                  created: el.created,
                  updated: el.updated
                }
              )
              ruas.polyline.point.push({
                    lat: el.altitude,
                    lng: el.longitude
                }
              )
              ruas.visible = true
              ruas.markersVisible = true
            }else{
              ruas.id_ruas_jalan = el.id_ruas_jalan
              ruas.nama_ruas_jalan = el.nama_ruas_jalan
              ruas.visible = true,
              ruas.markersVisible = true
              ruas.markers= [
                {
                  position: {
                    lat: el.altitude,
                    lng: el.longitude
                  },
                  tooltip: el.nama_jalan,
                  draggable: false,
                  visible: true,
                  gambar_koordinat: el.gambar_koordinat,
                  gambar_rambu: el.gambar_rambu,
                  nama_arah_jalan: el.nama_arah_jalan,
                  kode_desa: el.kode_desa,
                  kelurahan: el.kelurahan,
                  kode_kecamatan: el.kode_kecamatan,
                  kondisi: el.kondisi,
                  nama_desa: el.nama_desa,
                  nama_jalan: el.nama_jalan,
                  nama_kecamatan: el.nama_kecamatan,
                  nama_perlengkapan: el.nama_perlengkapan,
                  created: el.created,
                  updated: el.updated
                }]
              ruas.polyline = [{
                  point: [{
                    lat: el.altitude,
                    lng: el.longitude
                  }],
                  visible: true
                }]
            }
            hasil.push(ruas)
          })
        }
        this.tersedia = hasil
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    },
    loadKebutuhan() {
      this.loading = true
      this.tersedia = []
      var hasil = []
      request({ url: 'kebutuhan?size=-1', method: 'GET'}).then(res => {
        const data = res.data
        if (data.status) {
          data.data.forEach(el => {
            const ind = hasil.findIndex(p => p.id_ruas_jalan == el.id_ruas_jalan)
            var ruas = {}
            if (ind > -1) {
              ruas.id_ruas_jalan = el.id_ruas_jalan
              ruas.nama_ruas_jalan = el.nama_ruas_jalan
              ruas.markers.push(
                {
                  position: {
                    lat: el.altitude,
                    lng: el.longitude
                  },
                  tooltip: el.nama_jalan,
                  draggable: false,
                  visible: true,
                  gambar_koordinat: el.gambar_koordinat,
                  gambar_rambu: el.gambar_rambu,
                  nama_arah_jalan: el.nama_arah_jalan,
                  kode_desa: el.kode_desa,
                  kelurahan: el.kelurahan,
                  kode_kecamatan: el.kode_kecamatan,
                  kondisi: el.kondisi,
                  nama_desa: el.nama_desa,
                  nama_jalan: el.nama_jalan,
                  nama_kecamatan: el.nama_kecamatan,
                  nama_perlengkapan: el.nama_perlengkapan,
                  created: el.created,
                  updated: el.updated
                }
              )
              ruas.polyline.point.push({
                    lat: el.altitude,
                    lng: el.longitude
                }
              )
              ruas.visible = true
              ruas.markersVisible = true
            }else{
              ruas.id_ruas_jalan = el.id_ruas_jalan
              ruas.nama_ruas_jalan = el.nama_ruas_jalan
              ruas.visible = true,
              ruas.markersVisible = true
              ruas.markers= [
                {
                  position: {
                    lat: el.altitude,
                    lng: el.longitude
                  },
                  tooltip: el.nama_jalan,
                  draggable: false,
                  visible: true,
                  gambar_koordinat: el.gambar_koordinat,
                  gambar_rambu: el.gambar_rambu,
                  nama_arah_jalan: el.nama_arah_jalan,
                  kode_desa: el.kode_desa,
                  kelurahan: el.kelurahan,
                  kode_kecamatan: el.kode_kecamatan,
                  kondisi: el.kondisi,
                  nama_desa: el.nama_desa,
                  nama_jalan: el.nama_jalan,
                  nama_kecamatan: el.nama_kecamatan,
                  nama_perlengkapan: el.nama_perlengkapan,
                  created: el.created,
                  updated: el.updated
                }]
              ruas.polyline = [{
                  point: [{
                    lat: el.altitude,
                    lng: el.longitude
                  }],
                  visible: true
                }]
            }
            hasil.push(ruas)
          })
        }
        this.kebutuhan = hasil
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    }
  },
};
</script>