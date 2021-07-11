<template>
  <v-container>
    <Table :headers="headers" :primary-key="primaryKey" :title="title" :path="path" :edit="allowEdit" :new="allowNew" :deletes="allowDelete" :filter-data="filterData">
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
          value: 'id_desa',
          form: false,
          input: 'auto',
          rules: []
        },
        {
          text: 'KODE DESA',
          align: 'center',
          width: '20%',
          sortable: false,
          value: 'kode_desa',
          input: 'text',
          rules: [
            v => !!v || 'Kode desa is Required'
          ]
        },
        {
          text: 'NAMA Desa',
          align: 'start',
          width: '50%',
          sortable: false,
          value: 'nama_desa',
          input: 'text',
          rules: [
            v => !!v || 'Nama Desa is Required'
          ]
        },
        {
          text: 'Kecamatan',
          align: 'start',
          width: '50%',
          sortable: false,
          value_form: 'id_kecamatan',
          value: 'nama_kecamatan',
          input: 'select',
          list: [],
          rules: [
            v => !!v || 'Nama Kecamatan is Required'
          ]
        },
        {
          text: 'Kelurahan',
          align: 'center',
          width: '10%',
          sortable: false,
          value: 'kelurahan',
          input: 'checkbox',
          rules: [],
          change: (itm) => itm == 1 ? 'Ya' : 'Tidak' 
        }
      ],
      title: "Daftar Desa",
      path: "desa",
      allowEdit: true,
      allowNew: true,
      filterData: [
          {
              items: [],
              label: 'Kecamatan',
              value: 'id_kecamatan'
          }
      ],
      primaryKey: 'id_desa',
      allowDelete: true
    }
  },
  mounted() {
    this.loadData()
  },
  methods: {
      async loadData() {
          this.loading = true
          await this.getKecamatan()
          this.loading = false
      },
      getKecamatan() {
          request({ url: 'kecamatan?size=1000', method: 'GET'}).then(res => {
              var data = []
              if (res.data.status) {
                  res.data.data.forEach(el => {
                      data.push({ text: el.nama_kecamatan, value: el.id_kecamatan })
                  })
              }
              this.filterData[0].items = data
              this.headers[3].list = data
          })
      }
  }
}
</script>
