<template>
    <v-container>
        <v-file-input
    v-model="files"
    color="deep-purple accent-4"
    counter
    label="File input"
    multiple
    placeholder="Select your files"
    prepend-icon="mdi-paperclip"
    outlined
    :loading="loading"
    :show-size="1000"
  >
    <template v-slot:selection="{ index, text }">
      <v-chip
        v-if="index < 2"
        color="deep-purple accent-4"
        dark
        label
        small
      >
        {{ text }}
      </v-chip>

      <span
        v-else-if="index === 2"
        class="text-overline grey--text text--darken-3 mx-2"
      >
        +{{ files.length - 2 }} File(s)
      </span>
    </template>
    <template v-slot:append-outer>
        <v-btn color="info" @click="save()" large dark style="margin-top: -13px"><v-icon>mdi-disk</v-icon> SAVE</v-btn>
    </template>
  </v-file-input>
        <v-row style="padding: 5px">
            <v-col
            v-for="(item, index) in data"
            :key="index"
            class="d-flex child-flex"
            cols="4"
            >
            <v-card>
            <v-img
                :src="item.img"
                :lazy-src="item.img"
                aspect-ratio="1"
                class="grey lighten-2"
            >
                <template v-slot:placeholder>
                <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                >
                    <v-progress-circular
                    indeterminate
                    color="grey lighten-5"
                    ></v-progress-circular>
                </v-row>
                </template>
            </v-img>
            <v-card-actions>
                <span>{{item.created}}</span>
                <v-spacer></v-spacer>
                <v-btn dark color="red" @click="del(item)">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </v-card-actions>
            </v-card>
            </v-col>
        </v-row>
  <v-dialog v-model="infoDialog.value" max-width="300px" persistent>
    <v-card :color="infoDialog.color" :dark="infoDialog.dark">
      <v-card-title class="text-h5">{{infoDialog.title}}</v-card-title>
      <v-card-text>{{infoDialog.text}}</v-card-text>
      <v-card-actions>
        <v-btn v-if="infoDialog.no" color="warning darken-1" dark @click="cancelDialog()">Batal</v-btn>
        <v-spacer></v-spacer>
        <v-btn v-if="infoDialog.yes" color="green darken-1" dark @click="acceptDialog(infoDialog.item)">Ya</v-btn>
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
    </v-container>
</template>
<script>
import request from '@/lib/request'
export default {
    data () {
        return {
            data: [],
            loading: false,
            files: [],
            snackbar: {
                color: '',
                value: false,
                timeout: 2000,
                text: ''
            },
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
        }
    },
    mounted() {
        this.loadData()
    },
    methods: {
        del(item) {
            this.infoDialog.title = 'Hapus Gambar'
            this.infoDialog.text = 'Apakah anda yakin menghapus gambar '+ item.idcorousel + '?'
            this.infoDialog.function = 'hapusgambar'
            this.infoDialog.item = item
            this.infoDialog.value = true
        },
        cancelDialog() {
            this.infoDialog = {
                title: '',
                text: '',
                dark: true,
                color: 'red lighten-1',
                function: '',
                item: {},
                value: false,
                yes: true,
                no: true
            }
        },
        acceptDialog(item) {
            request({ url: 'corousel/'+ item.idcorousel, method: 'DELETE' })
             .then(resp => {
                if (resp.data.status) {
                    this.snackbar.color = 'green'
                } else {
                    this.snackbar.color = 'red'
                }
                this.snackbar.text = resp.data.message
                this.snackbar.value = true
                this.infoDialog.value = false
                this.loading = false
                this.loadData()
                this.files = []
            }).catch(() => {
                this.snackbar.color = 'red'
                this.snackbar.text = 'Gagal menghapus gambar'
                this.snackbar.value = true
                this.infoDialog.value = false
                this.files = []
                this.loading = false
            })
        },
        save() {
            var form = new FormData()
            this.files.forEach(el => {
                form.append('file[]', el)
            })
            this.loading = true
            request({ url: 'corousel', method: 'POST', data: form, headers: { 'Content-Type': 'multipart/form-data'}})
            .then(resp => {
                if (resp.data.status) {
                    this.snackbar.color = 'green'
                } else {
                    this.snackbar.color = 'red'
                }
                this.snackbar.text = resp.data.message
                this.snackbar.value = true
                this.loading = false
                this.files = []
                this.loadData()
            }).catch(() => {
                this.snackbar.color = 'red'
                this.snackbar.text = 'Gagal menambahkan gambar'
                this.snackbar.value = true
                this.loading = false
                this.files = []
            })
        },
        loadData() {
            this.loading = true
            request({ url: 'corousel', method: 'GET' }).then(resp => {
                if (resp.data.status) {
                    this.data = resp.data.data
                }
                this.loading = false
            }).catch(()=>{
                this.loading = false
            })
        }
    }
}
</script>
