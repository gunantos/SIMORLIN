<template>
  <v-container>
    <Table v-if="!loading" :headers="headers" :primary-key="primaryKey" :title="title" :path="path" :edit="allowEdit" :new="allowNew" :deletes="allowDelete" :filter-data="filterData">
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
          width: '10%',
          align: 'start',
          sortable: false,
          hide: true,
          form: false,
          value: 'id_jalan',
          input: 'auto',
          rules: []
        },
        {
          text: 'NAMA JALAN',
          align: 'start',
          width: '20%',
          sortable: false,
          value: 'nama_jalan',
          input: 'text',
          rules: [
            v => !!v || 'Kode desa is Required'
          ]
        },
        {
          text: 'DESA',
          align: 'start',
          width: '20%',
          sortable: false,
          value_form: 'id_desa',
          value: 'nama_desa',
          input: 'select',
          list: [],
          rules: [
            v => !!v || 'Nama Desa is Required'
          ]
        },
        {
          text: 'RUAS JALAN',
          align: 'center',
          width: '20%',
          sortable: false,
          value_form: 'id_ruas_jalan',
          value: 'nama_ruas_jalan',
          input: 'select',
          rules: [],
          list: [],
          change: null
        }
      ],
      title: "Daftar Jalan",
      path: "jalan",
      allowEdit: true,
      allowNew: true,
      primaryKey: 'id_jalan',
      filterData: [
          {
              items: [],
              label: 'Desa',
              value: 'id_desa'
          },
          {
              items: [],
              label: 'Ruas Jalan',
              value: 'id_ruas_jalan'
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
          await this.getDesa()
          await this.getRuas()
          this.loading = false
      },
      getDesa() {
          request({ url: 'desa?size=1000', method: 'GET'}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_desa, value: el.id_desa })
                  })
              }
              this.filterData[0].items = data
              this.headers[2].list = data
          })
      },
      getRuas() {
          request({ url: 'ruas?size=1000', method: 'GET'}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_ruas_jalan, value: el.id_ruas_jalan })
                  })
              }
              this.filterData[1].items = data
              this.headers[3].list = data
          })
      }
  }
}
</script>
