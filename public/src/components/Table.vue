<template>
  <v-data-table
    :headers="headers"
    :items="data"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"
              >Tambah</v-btn
            >
            <v-card-title
              ><span class="text-h5">{{ formTitle }}</span></v-card-title
            >
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12"></v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </template>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
  </v-data-table>
</template>
<script>
import request from "@/lib/request";

export default {
  props: {
    title: String,
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
  data() {
    return {
      data: [],
      formTitle: "",
      itemform: [],
      isedit: false,
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      request({ url: this.path, methods: "GET" }).then((resp) => {
        if (resp.data.data !== undefined) {
          this.data = resp.data.data;
        }
      });
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
    deleteData() {},
    newItem() {},
    deleteItem() {},
    editItem() {},
  },
};
</script>
