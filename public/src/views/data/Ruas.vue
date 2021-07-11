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
          align: 'start',
          sortable: false,
          value: 'id_ruas_jalan',
          hide: true,
          input: 'auto',
          form: false,
          rules: []
        },
        {
          text: 'RUAS JALAN',
          align: 'center',
          width: '70%',
          sortable: false,
          value: 'nama_ruas_jalan',
          input: 'text',
          rules: [
            v => !!v || 'Nama Ruas Jalan is Required'
          ]
        }
      ],
      title: "Daftar Ruas Jalan",
      path: "ruas",
      allowEdit: true,
      allowNew: true,
      filterData: [],
      primaryKey: 'id_ruas_jalan',
      allowDelete: true
    }
  },
  mounted() {
  },
  methods: {}
}
</script>
