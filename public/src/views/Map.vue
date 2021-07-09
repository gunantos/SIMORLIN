<template>
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
    <l-marker
      v-for="marker in markers"
      :key="marker.id"
      :visible="marker.visible"
      :draggable="marker.draggable"
      :lat-lng.sync="marker.position"
      :icon="marker.icon"
      @click="alert(marker)"
    >
      <l-popup :content="marker.tooltip" />
      <l-tooltip :content="marker.tooltip" />
    </l-marker>
    <l-layer-group layer-type="overlay" name="TERSEDIA">
      <l-polyline
        v-for="item in polylines"
        :key="item.id"
        :lat-lngs="item.points"
        :visible="item.visible"
        @click="alert(item)"
      />
    </l-layer-group>
    <l-layer-group
      v-for="item in stuff"
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
          @click="alert(marker)"
        />
      </l-layer-group>
      <l-polyline
        :lat-lngs="item.polyline.points"
        :visible="item.polyline.visible"
        @click="alert(item.polyline)"
      />
    </l-layer-group>
  </l-map>
</template>
<script>
import { latLngBounds } from "leaflet";
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
const poly1 = [
  { lng: -1.219482, lat: 47.41322 },
  { lng: -1.571045, lat: 47.457809 },
];
const markers1 = [
  {
    position: { lng: -1.219482, lat: 47.41322 },
    visible: true,
    draggable: true,
  },
];
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
      stuff: [
        {
          id: "s1",
          markers: markers1,
          polyline: { points: poly1, visible: true },
          visible: true,
          markersVisible: true,
        },
      ],
      bounds: latLngBounds(
        { lat: -7.0194419, lng: 107.5610011 },
        { lat: -6.9946788, lng: 107.5634318 }
      ),
    };
  },
  methods: {
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
    fitPolyline: function () {
      const bounds = latLngBounds(markers1.map((o) => o.position));
      this.bounds = bounds;
    },
  },
};
</script>