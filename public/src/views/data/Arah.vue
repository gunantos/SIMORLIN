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
          hide: true,
          form: false,
          value: 'id_arah_jalan',
          input: 'auto',
          rules: []
        },
        {
          text: 'ARAH JALAN',
          align: 'center',
          width: '70%',
          sortable: false,
          value: 'nama_arah_jalan',
          input: 'text',
          rules: [
            v => !!v || 'Arah Jalan is Required'
          ]
        }
      ],
      title: "Daftar Arah Jalan",
      path: "arah",
      allowEdit: true,
      allowNew: true,
      filterData: [],
      primaryKey: 'id_arah_jalan',
      allowDelete: true
    }
  },
  mounted() {
  },
  methods: {}
}
</script>
