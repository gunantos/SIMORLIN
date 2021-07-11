<template>
  <v-container>
    <Table :headers="headers" :primary-key="primaryKey" :title="title" :path="path" :edit="allowEdit" :new="allowNew" :deletes="allowDelete"></Table>
  </v-container>
</template>
<script>
import Table from '@/components/Table'
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
          value: 'id_kecamatan',
          form: false,
          input: 'auto',
          rules: []
        },
        {
          text: 'KODE KECAMATAN',
          align: 'center',
          width: '20%',
          sortable: false,
          value: 'kode_kecamatan',
          input: 'text',
          rules: [
            v => !!v || 'Kode kecamatan is Required'
          ]
        },
        {
          text: 'NAMA KECAMATAN',
          align: 'start',
          width: '60%',
          sortable: false,
          value: 'nama_kecamatan',
          input: 'text',
          rules: [
            v => !!v || 'Nama kecamatan is Required'
          ]
        }
      ],
      title: "Daftar Kecamatan",
      path: "kecamatan",
      allowEdit: true,
      allowNew: true,
      primaryKey: 'id_kecamatan',
      allowDelete: true
    }
  }
}
</script>
