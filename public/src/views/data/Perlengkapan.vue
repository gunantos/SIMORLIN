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
          align: 'center',
          sortable: false,
          hide: true,
          value: 'id_jenis_pelengkapan',
          input: 'auto',
          form: false,
          rules: []
        },
        {
          text: 'NAMA PERLENGKAPAN',
          align: 'start',
          width: '70%',
          sortable: false,
          value: 'nama_perlengkapan',
          input: 'text',
          rules: [
            v => !!v || 'PERLENGKAPAN is Required'
          ]
        }
      ],
      title: "Daftar Perlengkapan",
      path: "perlengkapan",
      allowEdit: true,
      allowNew: true,
      filterData: [],
      primaryKey: 'id_jenis_pelengkapan',
      allowDelete: true
    }
  },
  mounted() {
  },
  methods: {}
}
</script>
