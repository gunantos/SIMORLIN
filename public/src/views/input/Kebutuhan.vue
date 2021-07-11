<template>
  <v-container>
    <Table v-if="!loading" :headers="headers" :is-upload="true" @getDesa="getDesa" :primary-key="primaryKey" :title="title" :path="path" :edit="allowEdit" :new="allowNew" :deletes="allowDelete" :filter-data="filterData">
        <template v-slot:item="{item}">
            <span v-if="item=='kelurahan'">testsass</span>
        </template>
    </Table>
  </v-container>
</template>
<script>
import Table from '@/components/Table'
import request from '@/lib/request'
export default {
  components: {
    Table
  },
  data() {
    return {
      headers: [
        {
          text: 'ID',
          width: '3%',
          align: 'start',
          form: false,
          sortable: false,
          hide: true,
          value: 'id_tersedia',
          input: 'auto',
          rules: []
        },
        {
          text: 'NAMA JALAN',
          align: 'start',
          width: '20%',
          sortable: false,
          value_form: 'id_jalan',
          value: 'nama_jalan',
          input: 'select',
          list: [],
          rules: [
            v => !!v || 'Required'
          ]
        },
        {
          text: 'ARAH JALAN',
          align: 'start',
          width: '10%',
          sortable: false,
          value: 'nama_arah_jalan',
          value_form: 'id_arah_jalan',
          input: 'select',
          list: [],
          rules: [
            v => !!v || ' Required'
          ]
        },
        {
          text: 'KECAMATAN',
          align: 'start',
          width: '20%',
          hide: true,
          form: false,
          sortable: false,
          value_form: 'id_desa',
          value: 'nama_desa',
          input: 'select',
          list: [],
          rules: []
        },
        {
          text: 'DESA',
          align: 'start',
          hide: true,
          width: '20%',
          sortable: false,
          form: false,
          value_form: 'id_desa',
          value: 'nama_desa',
          input: 'select',
          list: [],
          rules: []
        },
        {
          text: 'RUAS JALAN',
          align: 'center',
          width: '10%',
          sortable: false,
          value_form: 'id_ruas_jalan',
          value: 'nama_ruas_jalan',
          input: 'select',
          rules: [],
          list: [],
          change: null
        },
        {
          text: 'RAMBU',
          align: 'center',
          width: '10%',
          sortable: false,
          value_form: 'id_perlengkapan',
          value: 'nama_perlengkapan',
          input: 'select',
          rules: [],
          list: [],
          change: null
        },
        {
          text: 'ALTITUDE',
          align: 'center',
          width: '20%',
          sortable: false,
          value_form: '',
          value: 'altitude',
          input: 'text',
          rules: [],
          list: [],
          change: null
        },
        {
          text: 'LONGITUDE',
          align: 'center',
          width: '20%',
          sortable: false,
          value_form: '',
          value: 'longitude',
          input: 'text',
          rules: [],
          list: [],
          change: null
        },
      ],
      title: "Daftar Kebutuhan",
      path: "kebutuhan",
      allowEdit: true,
      allowNew: true,
      primaryKey: 'id_kebutuhan',
      filterData: [
          {
              items: [],
              label: 'Kecamatan',
              value: 'id_kecamatan',
              onchange: 'getDesa'
          },
          {
              items: [],
              label: 'Desa',
              value: 'id_desa'
          },
          {
              items: [],
              label: 'Arah Jalan',
              value: 'id_arah_jalan'
          },
          {
              items: [],
              label: 'Ruas Jalan',
              value: 'id_ruas_jalan'
          },
          {
              items: [],
              label: 'Rambu Jalan',
              value: 'id_perlengkapan'
          },
          {
            items: [
                {
                  text: 'Baik', value: 'baik',
                },
                {
                  text: 'Rusak', value: 'rusak',
                }
              ],
              label: 'Kondisi',
              value: 'kondisi'
          }
      ],
      allowDelete: true,
      loading: false
    }
  },
  mounted() {
    this.loadData()
  },
  methods: {
      async loadData() {
          this.loading = true
          await this.getKecamatan()
          await this.getJalan()
          await this.getRuas()
          await this.getArah()
          await this.getPerlengkapan()
          this.loading = false
      },
      getKecamatan() {
          request({ url: 'kecamatan?size=1000', method: 'GET' }).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_kecamatan, value: el.id_kecamatan })
                  })
              }
              this.filterData[0].items = data
          })
      },
      getDesa(id) {
          request({ url: 'desa?id_kecamatan='+ id +'&size=1000', method: 'GET' }).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_desa, value: el.id_desa })
                  })
              }
              this.filterData[1].items = data
          })
      },
      getJalan() {
          request({ url: 'jalan?size=1000', method: 'GET' }).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_desa, value: el.id_desa })
                  })
              }
              this.headers[1].list = data
          })
      },
      getRuas() {
         var param = new FormData()
          param.append('size', 1000)
          request({ url: 'ruas', method: 'GET', data: param}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_ruas_jalan, value: el.id_ruas_jalan })
                  })
              }
              this.filterData[3].items = data
              this.headers[5].list = data
          })
      },
      getArah() {
         var param = new FormData()
          param.append('size', 1000)
          request({ url: 'arah', method: 'GET', data: param}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_arah_jalan, value: el.id_arah_jalan })
                  })
              }
              this.filterData[2].items = data
              this.headers[2].list = data
          })
      },
      getPerlengkapan() {
         var param = new FormData()
          param.append('size', 1000)
          request({ url: 'perlengkapan', method: 'GET', data: param}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_perlengkapan, value: el.id_jenis_pelengkapan })
                  })
              }
              this.filterData[4].items = data
              this.headers[6].list = data
          })
      }
  }
}
</script>
