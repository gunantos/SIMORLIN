<template>
  <v-container style="z-index: 0; width:100%; height: 100%; position:relative; padding: 0px">
  <l-map
    :zoom.sync="zoom"
    :options="mapOptions"
    :center="center"
    :bounds="bounds"
    :min-zoom="minZoom"
    :max-zoom="maxZoom"
    ref="mymap"
    style="height: 100%; width: 100%; z-index: 0"
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
      <l-layer-group :visible="item.markersVisible">
        <l-marker
          v-for="marker in item.markers"
          :key="marker.id"
          :visible="marker.visible"
          :draggable="marker.draggable"
          :lat-lng="marker.position"
          @click="clickTersedia(marker)"
        />
        <l-popup :content="item.tooltip || ''" />
        <l-tooltip :content="item.tooltip || ''" />
      </l-layer-group>
      <l-polyline
        :lat-lngs="item.polyline.points"
        :visible="item.polyline.visible"
        @click="clickTersedia(item.polyline)"
      />
    </l-layer-group>
    <l-layer-group
      v-for="item in kebutuhan"
      :key="item.id"
      :visible.sync="item.visible"
      layer-type="overlay"
      name="KEBUTUHAN"
    >
      <l-layer-group :visible="item.markersVisible">
        <l-marker
          v-for="marker in item.markers"
          :key="marker.id"
          :visible="marker.visible"
          :draggable="marker.draggable"
          :lat-lng="marker.position"
          @click="clickKebutuhan(marker)"
          :icon="markerspng"
        />
        <l-popup :content="item.tooltip || ''" />
        <l-tooltip :content="item.tooltip || ''" />
      </l-layer-group>
      <l-polyline
        :lat-lngs="item.polyline.points"
        :visible="item.polyline.visible"
        @click="clickKebutuhan(item.polyline)"
      />
    </l-layer-group>
  </l-map>
  <v-dialog
    v-model="dialog"
    persistent
    max-width="780px">
    <v-card>
      <v-toolbar dense color="info" dark>
        <v-toolbar-title>{{ isTersedia ? 'TERSEDIA' : 'KEBUTUHAN' }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeModal()">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-container>
      <v-simple-table style="font-weight: 800;margin-bottom: 10px">
        <template v-slot:default>
          <tbody>
          <tr>
            <td width="20%">Nama Jalan</td><td width="2%">:</td><td>{{ itemSelect.nama_jalan}}</td>
          </tr>
          <tr>
            <td width="20%">Kecamatan</td><td width="2%">:</td><td>{{ itemSelect.nama_kecamatan}}</td>
          </tr>
          <tr>
            <td width="20%">{{ itemSelect.kelurahan == '1' || itemSelect.kelurahan == 1 ? 'Kelurahan' : 'Desa' }}</td><td width="2%">:</td><td>{{ itemSelect.nama_desa}}</td>
          </tr>
          <tr>
            <td width="20%">Ruas Jalan</td><td width="2%">:</td><td>{{ itemSelect.nama_ruas_jalan}}</td>
          </tr>
          <tr>
            <td width="20%">Arah Jalan</td><td width="2%">:</td><td>{{ itemSelect.nama_jalan}}</td>
          </tr>
          <tr>
            <td width="20%">{{ isTersedia ? 'Tersedia' : 'Kebutuhan'}}</td><td width="2%">:</td><td>{{ itemSelect.nama_perlengkapan}}</td>
          </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row v-if="isTersedia">
        <v-col cols="12" sm="6">
          <v-card>
            <v-card-title class="text-h6">GAMBAR RAMBU</v-card-title>
          <v-img :src="itemSelect.gambar_rambu" @click="viewImage(itemSelect.gambar_rambu)" style="cursor:pointer"></v-img>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6">
           <v-card>
            <v-card-title class="text-h6">GAMBAR KOORDINAT</v-card-title>
          <v-img :src="itemSelect.gambar_koordinat" @click="viewImage(itemSelect.gambar_koordinat)" style="cursor:pointer"></v-img>
          </v-card>
        </v-col>
      </v-row>
      </v-container>
    </v-card>
  </v-dialog>
  <v-dialog v-model="fullImage" fullscreen>
    <v-toolbar dense flat color="transparent" style="position: absolute;z-index:999;padding-right: 20px; padding-top: 10px">
            <v-spacer></v-spacer>
            <v-btn fab color="red" dark @click.native="closePictureDialog" @click="fullImage = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar>
    <v-img :src="itemImageSelected" contain cover width="100%" height="100%"></v-img>
  </v-dialog>
  </v-container>
</template>
<script>
import { latLngBounds, icon } from "leaflet";
import 'leaflet-draw';
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
import 'leaflet-fullscreen/dist/leaflet.fullscreen.css';
import 'leaflet-fullscreen/dist/Leaflet.fullscreen';

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
      opacity: 0.6,
      token: "your token if using mapbox",
      mapOptions: {
        zoomControl: false,
        attributionControl: false,
        zoomSnap: true,
      },
      markerspng: icon({
        iconUrl: markerspng,
        iconSize: [40, 41],
        iconAnchor: [16, 17]
      }),
      zoom: 3,
      minZoom: 2,
      maxZoom: 18,
      zoomPosition: "topleft",
      attributionPosition: "bottomright",
      layersPosition: "topright",
      attributionPrefix: "SIMARLIN",
      imperial: false,
      Positions: ["topleft", "topright", "bottomleft", "bottomright"],
      tileProviders: tileProviders,
      bounds: latLngBounds(
        { lat: -7.0194419, lng: 107.5610011 },
        { lat: -6.9946788, lng: 107.5634318 }
      ),
      kebutuhan: [],
      tersedia: [],
      dialog: false,
      itemSelect: {},
      isTersedia: false,
      fullImage: false,
      itemImageSelected: null
    };
  },
  mounted() {
    this.loadData()
    const map = this.$refs.mymap.mapObject;
    map.addControl(new window.L.Control.Fullscreen());
  },
  methods: {
    viewImage(itm) {
      this.itemImageSelected = itm
      this.fullImage = true
    },
    alert(item) {
      alert("this is " + JSON.stringify(item));
    },
    closeModal() {
      this.itemSelect = {}
      this.isTersedia = false
      this.dialog = false
    },
    clickTersedia(item) {
      this.itemSelect = item
      this.isTersedia = true
      this.dialog = true
    },
    clickKebutuhan(item) {
       this.itemSelect = item
      this.isTersedia = false
      this.dialog = true
    },
    async loadData() {
      await this.loadTersedia()
      await this.loadKebutuhan()
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
                  nama_ruas_jalan: el.nama_ruas_jalan,
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
                  nama_ruas_jalan: el.nama_ruas_jalan,
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
                  nama_ruas_jalan: el.nama_ruas_jalan,
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
                  nama_ruas_jalan: el.nama_ruas_jalan,
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