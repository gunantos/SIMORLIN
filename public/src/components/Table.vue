<template>
<div>
  <v-card v-if="Array.isArray(filterData) && filterData.length > 0" style="margin-bottom: 10px" color="blue lighten-5" >
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="6" :md="Math.ceil(12 / filterData.length)" v-for="(item, ind) in filterData" :key="ind">
          <v-select v-model="filter[item.value]" :items="item.items" :label="item.label" hide-details item-text="text" outlined item-value="value" @change="changeFilter(item)" clearable></v-select>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
  <v-data-table
    :headers="headerTable"
    :items="dataFinal"
    sort-by="calories"
    :options.sync="options"
    :server-items-length="totalData"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer> 
        <v-btn color="primary" dark class="mb-2" @click="tambahData()"
              >Tambah</v-btn
            >
        <v-dialog v-model="dialog" max-width="500px" persistent>
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
              <v-form ref="myForm" v-model="valid" 
    lazy-validation>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" v-for="(item, ind) in formData" :key="ind">
                        <v-file-input
                          v-if="item.input == 'file'"
                          v-model="itemform[item.value_form !== undefined && item.value_form !== null && item.value_form !== '' ? item.value_form : item.value]"
                          :rules="item.rules"
                          :label="item.text"
                          accept="image/png, image/jpeg, image/bmp, image/jpg"
                          prepend-icon="mdi-camera"
                          hide-details
                          outlined
                        ></v-file-input>
                        <v-textarea v-if="item.input == 'textarea'"
                          outlined
                          v-model="itemform[item.value_form !== undefined && item.value_form !== null && item.value_form !== '' ? item.value_form : item.value]"
                          :rules="item.rules"
                          :label="item.text"
                          hide-details
                        ></v-textarea>
                        <v-checkbox
                        v-if="item.input == 'checkbox'"
                          v-model="itemform[item.value_form !== undefined && item.value_form !== null && item.value_form !== '' ? item.value_form : item.value]"
                          :rules="item.rules"
                          :label="item.text"
                        ></v-checkbox>
                        <v-select v-else-if="item.input == 'select'"
                          v-model="itemform[item.value_form !== undefined && item.value_form !== null && item.value_form !== '' ? item.value_form : item.value]"
                          :rules="item.rules"
                          :label="item.text"
                          :items="item.list || []"
                          item-text="text" 
                          item-value="value"
                          outlined
                          clearable
                          hide-details
                        ></v-select>
                        <v-text-field v-else-if="item.input == 'text'"
                          v-model="itemform[item.value_form !== undefined && item.value_form !== null && item.value_form !== '' ? item.value_form : item.value]"
                          :rules="item.rules"
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
                <v-btn color="blue darken-1" @click="saveData()" :disabled="!valid" dark> Save </v-btn>
              </v-card-actions>
              </v-form>
            </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item="{ item, index}">
      <tr>
        <td width="10px">{{ getNumber(index) }}</td>
        <td v-for="(itm, ind) in valueTable" :key="ind" :width="itm.width">
            <v-img v-if="itm.type == 'gambar'" lazy-src="https://picsum.photos/id/11/10/6"  :src="item[itm.value]" max-height="150" max-width="150"></v-img>
            <v-chip v-else-if="itm.type == 'chip'"
              class="ma-2"
              :color="itm.chip_color !== undefined && typeof itm.chip_color == 'function' ? itm.chip_color(item[itm.value]) :'green'"
              outlined
            >
              {{ item[itm.value].toUpperCase() }}
            </v-chip>
            <span v-else>{{item[itm.value]}}</span>
        </td>
        <td v-if="edit || deletes" width="30px">
          <v-icon color="#EF6C00" v-if="edit" small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
         <v-icon color="#B71C1C" v-if="deletes"  small @click="deleteItem(item)"> mdi-delete </v-icon>
        </td>
      </tr>
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
    filterData: {
      type: Array,
      default: () => []
    },
    edit: {
      type: Boolean,
      default: true,
    },
    isUpload: {
      type: Boolean,
      default: false,
    },
    deletes: {
      type: Boolean,
      default: true,
    },
    new: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    formData() {
      var dat = []
      this.headers.forEach(el => {
        if (el.form == undefined || el.form == true) {
          dat.push(el)
        }
      })
      return dat
    },
    formTitle() {
      if (this.isedit) {
        return 'Edit ' + this.title
      } else {
        return 'Tambah '+ this.title
      }
    },
    dataFinal() {
      var out = []
      if (Array.isArray(this.data)) {
        this.data.forEach(el => {
          var itm = {}
          this.headerTable.forEach(ek => {
            if (ek.change !== undefined) {
              if (typeof ek.change == 'function') {
                itm[ek.value] = ek.change(el[ek.value])
              } else {
                itm[ek.value] = el[ek.value]
              }
            } else {
              itm[ek.value] = el[ek.value]
            }
          })
          out.push(itm)
        })
      }
      return out
    }
  },
  data() {
    return {
      totalData: 0,
      options: {},
      loading: false,
      data: [],
      headerTable: [],
      itemform: [],
      valid: false,
      dialog: false,
      filter: [],
      valueTable: [],
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
      valPrimary: null,
      snackbar: {
        color: '',
        value: false,
        timeout: 2000,
        text: ''
      }
    };
  },
  watch: {
      options: {
        handler () {
          this.loadData()
        },
        deep: true,
      },
  },
  mounted() {
    this.buildTable()
  },
  methods: {
    getNumber(index) {
      const { page, itemsPerPage  } = this.options
      let _page = 1
      let _size = 10
      if (page !== undefined) {
        _page = page
      }
      if (itemsPerPage !== undefined) {
        _size = itemsPerPage
      }
      return ((_page -1) * _size) + (index + 1)
    },
    changeFilter(item) {
      console.log(item)
      if (item.onchange !== undefined && item.onchange !== null && item.onchange !== '' && item.onchange !== 'null' ) {
        this.$emit(item.onchange, this.filter[item.value])
      } 
        this.loadData()
    },
    findIndexHeader(key) {
      console.log(key)
      return this.headerTable.findIndex(el => {
        return el.value == key
      })
    },
    tambahData() {
      this.isedit = false
      this.valPrimary = null
      this.dialog = true
    },
    buildTable() {
      this.loading = true
      this.headerTable = []
      this.itemform = []
      this.headerTable.push({
        text: '',
        align: 'center',
        sortable: false,
        value: '',
        input: 'none'
      })
      this.valueTable = []
      this.headers.forEach(el => {
        if (el.hide == undefined || el.hide == false) {
          this.headerTable.push(el)
          this.valueTable.push(el)
        }
      })
      this.headerTable.push({
        text: '',
        align: 'center',
        sortable: false,
        value: '',
        input: 'none'
      })
      this.loading = false
      this.loadData()
    },
    close() {
      this.isedit = false
      this.valPrimary = null
      this.dialog = false
      this.itemform =  {}
    },
    loadData() {
      this.loading = true
      var param = ''
      const { sortBy, sortDesc, page, itemsPerPage  } = this.options
      param = `?page=${page}&size=${itemsPerPage}&sortBy=${sortBy}&sortDesc=${sortDesc}`
      Object.keys(this.filter).forEach(el => {
        if (param == '') {
           param += '?' + el + '='+ this.filter[el]
         } else {
           param += '&' + el + '='+ this.filter[el]
         }
      })
      request({ url: this.path + param, methods: "GET"}).then((resp) => {
        if (resp.data.data !== undefined) {
          this.data = resp.data.data;
          this.totalData = resp.data.total;
        }
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    },
    saveData() {
      if (this.$refs.myForm.validate()) {
        if (this.isedit && this.isUpload == false) {
          this.save_edit();
        } else {
          this.save_new();
        }
      }
    },
    save_edit() {
      var params = {}
      Object.keys(this.itemform).forEach(el => {
        params[el] = this.itemform[el]
      })
       request({ url: this.path + '/'+ this.valPrimary, method: 'PUT', data: params }).then(resp => {
        if (resp.data.status) {
          this.isedit = false
          this.valPrimary = null
          this.loadData()
          this.dialog = false
          this.snackbar.text = resp.data.message
          this.snackbar.color = 'green'
          this.snackbar.value = true
          this.itemform = {}
          this.loading = false
        } else {
          this.isedit = false
          this.valPrimary = null
          this.dialog = false
          this.snackbar.text =  resp.data.message
          this.snackbar.color = 'red'
          this.snackbar.value = true
          this.itemform =  {}
          this.loading = false
        }
      }).catch(() => {
        this.isedit = false
        this.valPrimary = null
        this.dialog = false
        this.snackbar.text = 'Gagal menyimpan data'
        this.snackbar.color = 'red'
        this.snackbar.value = true
        this.itemform =  {}
          this.loading = false
      })
    },
    save_new() {
      this.loading = true
      var params = new FormData()
      Object.keys(this.itemform).forEach(el => {
        params.append(el, this.itemform[el])
      })
      var headers = {}
      if (this.isUpload) {
        headers = {
            'Content-Type': 'multipart/form-data'
        }
        params.append(this.primaryKey, this.valPrimary)
      }
      request({ url: this.path, method: 'POST', data: params, headers: headers }).then(resp => {
        if (resp.data.status) {
          this.isedit = false
          this.valPrimary = null
          this.loadData()
          this.dialog = false
          this.snackbar.text = resp.data.message
          this.snackbar.color = 'green'
          this.snackbar.value = true
          this.valPrimary = null
          this.itemform = {}
          this.loading = false
        } else {
          this.isedit = false
          this.valPrimary = null
          this.valPrimary = null
          this.dialog = false
          this.snackbar.text =  resp.data.message
          this.snackbar.color = 'red'
          this.snackbar.value = true
          this.itemform =  {}
          this.loading = false
        }
      }).catch(() => {
        this.isedit = false
        this.valPrimary = null
        this.dialog = false
          this.valPrimary = null
        this.snackbar.text = 'Gagal menambahkan data'
        this.snackbar.color = 'red'
        this.snackbar.value = true
        this.itemform =  {}
          this.loading = false
      })
    },
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
    editItem(item) {
      this.isedit = true
      this.valPrimary = item[this.primaryKey]
      Object.keys(item).forEach(el => {
        if (el  !== this.primaryKey) {
          this.itemform[el] = item[el]
        }
      })
      this.dialog = true
    },
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
