<template>
  <v-container>
    <Table :headers="headers" :primary-key="primaryKey" :title="title" :path="path" :edit="allowEdit" :new="allowNew" :delete="allowDelete"></Table>
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
          value: 'id_kecamatan',
          input: 'auto'
        },
        {
          text: 'KODE KECAMATAN',
          align: 'center',
          width: '20%',
          sortable: false,
          value: 'kode_kecamatan',
          input: 'text'
        },
        {
          text: 'NAMA KECAMATAN',
          align: 'start',
          width: '60%',
          sortable: false,
          value: 'nama_kecamatan',
          input: 'text'
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
