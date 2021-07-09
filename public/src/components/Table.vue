<template>
<div>
  <v-data-table
    :headers="headerTable"
    :items="data"
    sort-by="calories"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px" persistent>
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"
              >Tambah</v-btn
            >
          </template>
            <v-card>
              <v-card-title style="padding: 0px;">
                <v-toolbar color="info" class="pt-1" dark>
                  <v-toolbar-title>{{formTitle}}</v-toolbar-title>
                  <v-spacer></v-spacer>
                    <v-btn icon @click="close()">
                      <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                </v-card-title
              >
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" v-for="(item, ind) in headers" :key="ind">
                      <v-textarea v-if="item.input == 'textarea'"
                        outlined
                        v-model="itemform[item.value]"
                        :label="item.text"
                        hide-details
                      ></v-textarea>
                      <v-select v-else-if="item.input == 'select'"
                        v-model="itemform[item.value]"
                        :label="item.text"
                        :items="item.list || []"
                        outlined
                        clearable
                        hide-details
                      ></v-select>
                      <v-text-field v-else-if="item.input == 'text'"
                        v-model="itemform[item.value]"
                        :label="item.text"
                        outlined
                        clearable
                        hide-details
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-btn color="red lighten-1" @click="close()" dark> Cancel </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" @click="save()" dark> Save </v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon color="#EF6C00" small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon color="#B71C1C"  small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
    <template v-slot:no-data>
      Data masih kosong
    </template>
  </v-data-table>
  <v-dialog v-model="infoDialog.value" max-width="300px" persistent>
    <v-card :color="infoDialog.color" :dark="infoDialog.dark">
      <v-card-title class="text-h5">{{infoDialog.title}}</v-card-title>
      <v-card-text>{{infoDialog.text}}</v-card-text>
      <v-card-actions>
        <v-btn v-if="infoDialog.no" color="warning darken-1" dark @click="cancelDialog(infoDialog.function)">Batal</v-btn>
        <v-spacer></v-spacer>
        <v-btn v-if="infoDialog.yes" color="green darken-1" dark @click="acceptDialog(infoDialog.function, infoDialog.item)">Ya</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <v-snackbar
      v-model="snackbar.value"
      :timeout="snackbar.timeout || 2000"
      :color="snackbar.color"
    >
      {{ snackbar.text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackbar.value = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>
<script>
import request from "@/lib/request";

export default {
  props: {
    title: String,
    primaryKey: String,
    headers: Array,
    path: String,
    edit: {
      type: Boolean,
      default: true,
    },
    delete: {
      type: Boolean,
      default: true,
    },
    new: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    formTitle() {
      if (this.isedit) {
        return 'Edit ' + this.title
      } else {
        return 'Tambah '+ this.title
      }
    }
  },
  data() {
    return {
      loading: false,
      data: [],
      headerTable: [],
      itemform: [],
      dialog: false,
      isedit: false,
      infoDialog: {
        title: '',
        text: '',
        dark: true,
        color: 'red lighten-1',
        function: '',
        item: {},
        value: false,
        yes: true,
        no: true
      },
      snackbar: {
        color: '',
        value: false,
        timeout: 2000,
        text: ''
      }
    };
  },
  mounted() {
    this.buildTable()
  },
  methods: {
    buildTable() {
      this.loading = true
      this.headerTable = []
      this.itemform = []
      this.headers.forEach(el => {
        this.headerTable.push(el)
      })
      this.headerTable.push({
        text: '',
        align: 'center',
        sortable: false,
        value: 'actions',
          width: '10%',
        input: 'none'
      })
      this.loading = false
      this.loadData()
    },
    close() {
      this.dialog = false
    },
    loadData() {
      this.loading = true
      request({ url: this.path, methods: "GET" }).then((resp) => {
        if (resp.data.data !== undefined) {
          this.data = resp.data.data;
        }
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    },
    saveData() {
      if (this.isedit) {
        this.save_edit();
      } else {
        this.save_new();
      }
    },
    save_edit() {
      const params = [];
      request({ url: this.path, methods: "POST", params })
        .then((resp) => {
          const data = resp.data;
          this.data = data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    save_new() {},
    deleteData(id) {
      this.loading = true
      request({ url: this.path+'/'+id, method: 'delete'}).then(resp => {
        if (resp.data.status) {
          this.infoDialog.value = false
          this.snackbar.color = 'green'
        } else {
          this.snackbar.color = 'red'
          this.infoDialog.value = false
        }
        this.snackbar.text = resp.data.message
        this.snackbar.value = true
        this.loading = false
        this.loadData()
      }).catch(() => {
        this.loading = false
        this.infoDialog.value = false
        this.snackbar.text = 'Gagal menghapus data'
        this.snackbar.color = 'red'
        this.snackbar.value = true
      })
    },
    newItem() {},
    deleteItem(item) {
      this.infoDialog = {
        title: 'Hapus data '+ item[this.primaryKey],
        text: 'Apakah anda yakin menghapus data?',
        dark: true,
        color: 'red lighten-1',
        function: 'delete',
        item: item,
        value: true,
        yes: true,
        no: true
      }
    },
    editItem() {},
    acceptDialog(f, item) {
      switch(f) {
        case 'delete':
          return this.deleteData(item[this.primaryKey])
      }
    },
    cancelDialog(f) {
      switch(f) {
        case 'delete':
          this.infoDialog.value = false
        break;
      }
    }
  },
};
</script>
